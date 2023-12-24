<?php
// Display all installed PHP extensions
$extensions = get_loaded_extensions();

echo "Installed PHP extensions:\n";
foreach ($extensions as $extension) {
    echo "- $extension\n";
}
?>
