<?php
$files = glob("*.php");

$loginBlock = '<?php if (isset($_SESSION["user_id"])): ?>
                    <li><a href="pendaftaran.php">Pendaftaran</a></li>
                    <li><a href="profile.php" class="btn btn-outline" style="padding: 8px 20px; border-radius: 20px;"><i class="fa-regular fa-user"></i> Profile</a></li>
                <?php else: ?>
                    <li><a href="login.php" class="btn btn-primary" style="padding: 8px 20px; border-radius: 20px;">Login</a></li>
                <?php endif; ?>';

foreach ($files as $file) {
    // skip profile.php
    if ($file === 'profile.php' || $file === 'logout.php' || $file === 'db.php') continue;
    
    $content = file_get_contents($file);
    
    // Check if it has a navbar
    if (strpos($content, '<nav class="navbar"') !== false) {
        
        // Find the block inside <ul class="nav-links" id="nav-links">
        // It might be a PHP block or hardcoded links.
        // Easiest way: look for the closing </ul> of nav-links and inject or replace.
        // Actually, some files have Pendaftaran, Login/Logout blocks.
        // Let's replace the existing php if block inside nav-links.
        
        $pattern = '/<\?php if \(isset\(\$_SESSION\["user_id"\]\)\): \?>.*?<\?php endif; \?>/s';
        
        // If the pattern exists inside nav-links, replace it!
        // But the pattern also exists in footer!
        // We only want the first occurrence, which is in navbar.
        
        if (preg_match($pattern, $content, $matches)) {
            $pos = strpos($content, $matches[0]);
            // check if it's before footer (i.e. inside nav)
            $footerPos = strpos($content, '<footer');
            if ($pos < $footerPos) {
                $content = substr_replace($content, $loginBlock, $pos, strlen($matches[0]));
                file_put_contents($file, $content);
                echo "Updated PHP block in $file\n";
            }
        } else {
            // Some files like login.php, register.php, pendaftaran.php
            // don't have the PHP block in the navbar. They just have hardcoded <li> tags ending before </ul>
            // E.g. <li><a href="register.php">Register</a></li>
            // Let's find <ul class="nav-links" id="nav-links"> ... </ul>
            
            $start = strpos($content, '<ul class="nav-links" id="nav-links">');
            if ($start !== false) {
                $end = strpos($content, '</ul>', $start);
                $ulContent = substr($content, $start, $end - $start);
                
                // Let's clean up existing pendaftaran/login/register links inside ulContent
                $ulContent = preg_replace('/<li><a href="(pendaftaran|register|login|logout)\.php"[^>]*>.*?<\/a><\/li>/s', '', $ulContent);
                // Also remove active variants like <li class="active"><a href="pendaftaran.php">Pendaftaran</a></li>
                $ulContent = preg_replace('/<li[^>]*><a href="(pendaftaran|register|login|logout)\.php"[^>]*>.*?<\/a><\/li>/s', '', $ulContent);
                
                // Append the loginBlock
                $newUlContent = rtrim($ulContent) . "\n                " . $loginBlock . "\n            ";
                
                $content = substr_replace($content, $newUlContent, $start, $end - $start);
                file_put_contents($file, $content);
                echo "Updated hardcoded block in $file\n";
            }
        }
    }
}
echo "Done.\n";
