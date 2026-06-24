<?php
$files = glob('*.html');
foreach ($files as $file) {
    $new_name = str_replace('.html', '.php', $file);
    
    $content = file_get_contents($file);
    // Replace links to .html with .php
    $content = str_replace('.html', '.php', $content);
    
    // Add session_start() at the very beginning of the file to allow auth checks
    $session_code = "<?php\nsession_start();\n?>\n";
    $content = $session_code . $content;

    // We also need to add dynamic Login/Logout links to the navbar.
    // The current navbar has: <li><a href="pendaftaran.php">Pendaftaran</a></li>
    // Let's replace the pendaftaran link to conditionally show login/logout
    
    $nav_replacement = '
                <?php if (isset($_SESSION["user_id"])): ?>
                    <li><a href="pendaftaran.php">Pendaftaran</a></li>
                    <li><a href="logout.php" style="color: var(--accent-red);">Logout</a></li>
                <?php else: ?>
                    <li><a href="login.php" style="color: var(--accent-cyan);">Login</a></li>
                <?php endif; ?>
            </ul>';
            
    $content = preg_replace('/<li><a href="pendaftaran\.php">Pendaftaran<\/a><\/li>\s*<\/ul>/i', $nav_replacement, $content);

    file_put_contents($new_name, $content);
    unlink($file); // Remove the old html file
    echo "Migrated $file to $new_name\n";
}
?>
