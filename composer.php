<?php
// Download the installer script
copy('https://getcomposer.org/installer', 'composer-setup.php');

// Run the installer script
$hash = hash_file('SHA384', 'composer-setup.php');
$expectedHash = '48e97cb71f124c65a0ec92ecb9a9601e23b23a231fef226e76a8bcff036b8c9af13b2a764b6cd1b7fcdc95a61c7a8a9d';

if ($hash === $expectedHash) {
    echo 'Installer verified';
    $composerPath = './composer.phar';
    shell_exec('php composer-setup.php --install-dir=' . dirname(__FILE__) . ' --filename=composer.phar');
    unlink('composer-setup.php');
} else {
    echo 'Installer corrupt';
    unlink('composer-setup.php');
}
?>
