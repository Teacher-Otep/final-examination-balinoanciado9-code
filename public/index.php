<?php
/* ==========================================================================
   LABEL: TEACHER GITHUB COMPATIBLE PATH RESOLVER
   Automatically shifts paths whether running flat locally or inside /public/ on GitHub.
   ========================================================================== */
if (file_exists(__DIR__ . '/../includes/db.php')) {
    require_once __DIR__ . '/../includes/db.php';
    $form_action = '../includes/insert.php';
} elseif (file_exists(__DIR__ . '/includes/db.php')) {
    require_once __DIR__ . '/includes/db.php';
    $form_action = 'includes/insert.php';
} else {
    die("Configuration Error: includes/db.php could not be found.");
}

/* ==========================================================================
   LABEL: CORE ACTION CONTROLLER - UPDATE RECORD
   ========================================================================== */
if (isset($_POST['update'])) {
    $id = $_POST['id']; 
    $n = $_POST['name']; 
    $s = $_POST['surname']; 
    $m = $_POST['middlename'];
    
    try {
        $stmt = $pdo->prepare("UPDATE students SET name = :name, surname = :surname, middlename = :middlename WHERE id = :id");
        $stmt->execute([
            ':name'       => $n,
            ':surname'    => $s,
            ':middlename' => $m,
            ':id'         => $id
        ]);
        header("Location: index.php");
        exit();
    } catch (PDOException $e) {
        die("Update operational failure: " . $e->getMessage());
    }
}

/* ==========================================================================
   LABEL: CORE ACTION CONTROLLER - DELETE RECORD
   ========================================================================== */
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    
    try {
        $stmt = $pdo->prepare("DELETE FROM students WHERE id = :id");
        $stmt->execute([':id' => $id]);
        header("Location: index.php");
        exit();
    } catch (PDOException $e) {
        die("Delete operational failure: " . $e->getMessage());
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Management Pro</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
</head>
<body>

    <nav class="navbar">
        <div class="nav-container">
            <img src="logo.svg" id="logo" onclick="hideContent()" alt="System Logo" onerror="this.src='https://cdn-icons-png.flaticon.com/512/3135/3135715.png'">
            <div class="nav-links">
                <button class="nav-btn" onclick="showSection('create')">Create</button>
                <button class="nav-btn" onclick="showSection('read')">Read</button>
                <button class="nav-btn" onclick="showSection('update')">Update</button>
                <button class="nav-btn" onclick="showSection('delete')">Delete</button>
            </div>
        </div>
    </nav>

    <main class="main-container">
        
        <section id="home" class="homecontent"> 
            <h1 class="splash">Student Registry</h1>
            <p>Select an administration option from the top navigation menu to manage database data models.</p>
        </section>
        
        <section id="create" class="content card" style="display:none;">
            <h2 class="contenttitle">Register New Student</h2>
            <form action="<?php echo $form_action; ?>" method="POST" class="form-grid">
                <div class="input-group"><label>Surname</label><input type="text" name="surname" required></div>
                <div class="input-group"><label>First Name</label><input type="text" name="name" required></div>
                <div class="input-group"><label>Middle Name</label><input type="text" name="middlename"></div>
                <div class="input-group"><label>Home Address</label><input type="text" name="address"></div>
                <div class="input-group"><label>Contact Number</label><input type="text" name="contact"></div>
                <div class="btn-row">
                    <button type="button" class="btn-sec" onclick="clearFields()">Clear Fields</button>
                    <button type="submit" name="save" class="btn-pri">Save Records</button>
                </div>
            </form>   
        </section>

        <section id="read" class="content card" style="display:none;">
            <h2 class="contenttitle">Database Records</h2>
            <div class="table-wrapper">
                <table>
                    <thead>
                        <tr>
                            <th>ID Code</th>
                            <th>Surname</th>
                            <th>First Name</th>
                            <th>Middle Name</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        try {
                            $stmt = $pdo->query("SELECT * FROM students");
                            while($row = $stmt->fetch()) {
                                echo "<tr>
                                        <td><strong>#{$row['id']}</strong></td>
                                        <td>{$row['surname']}</td>
                                        <td>{$row['name']}</td>
                                        <td>{$row['middlename']}</td>
                                      </tr>";
                            }
                        } catch (PDOException $e) {
                            echo "<tr><td colspan='4'>Query Error: " . $e->getMessage() . "</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </section>

        <section id="update" class="content card" style="display:none;">
            <h2 class="contenttitle">Update Student Information</h2>
            <form method="POST" class="form-grid">
                <div class="input-group"><label>ID Target Reference</label><input type="number" name="id" required></div>
                <div class="input-group"><label>Revised Surname</label><input type="text" name="surname"></div>
                <div class="input-group"><label>Revised Name</label><input type="text" name="name"></div>
                <div class="input-group"><label>Revised Middle Name</label><input type="text" name="middlename"></div>
                <button type="submit" name="update" class="btn-pri full-width">Commit Updates</button>
            </form>
        </section>

        <section id="delete" class="content card" style="display:none;">
            <h2 class="contenttitle">Danger Zone</h2>
            <p style="color: var(--text-muted); margin-bottom: 1.5rem;">Select a student from the configuration map to permanently delete records from the data layer.</p>
            <div class="delete-list">
                <?php
                try {
                    $stmt = $pdo->query("SELECT * FROM students");
                    while($row = $stmt->fetch()) {
                        echo "<div class='delete-item'>
                                <span>{$row['name']} {$row['surname']}</span>
                                <a href='index.php?delete={$row['id']}' class='btn-del' onclick='return confirm(\"Are you sure you want to permanently delete this student?\");'>Remove Record</a>
                              </div>";
                    }
                } catch (PDOException $e) {
                    echo "<div>Query Error: " . $e->getMessage() . "</div>";
                }
                ?>
            </div>
        </section>
    </main>

    <div id="success-toast" class="toast">Record Processed Successfully!</div>

    <script src="script.js"></script>
</body>
</html>
