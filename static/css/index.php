<!DOCTYPE html>
<html>
<head>
    <title>文件列表</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
 
        .directory {
            font-weight: bold;
            margin-bottom: 10px;
            cursor: pointer;
            display: flex;
            align-items: center;
        }
 
        .directory-icon {
            margin-right: 5px;
        }
 
        .file {
            margin-left: 20px;
        }
 
        .file a {
            text-decoration: none;
            color: #0000EE;
        }
 
        .file a:hover {
            text-decoration: underline;
        }
 
        .indent {
            margin-left: 20px;
        }
 
        .collapsed {
            display: none;
        }
 
        .file-size {
            margin-right: 50px;
        }
    </style>
    <script>
        function toggleDirectory(element) {
            var subDirectory = element.nextElementSibling;
            if (subDirectory.style.display === 'none') {
                subDirectory.style.display = 'block';
            } else {
                subDirectory.style.display = 'none';
            }
        }
    </script>
</head>
<body>
<h2>Index of /文件列表/</h2>
 
 
<div style="width:650px;">
<div class="file">
	<span style="margin-right: 265px;">文件/文件夹</span>
    <span style="margin-right: 95px;">大小</span>
    <span class="file-modified" >Date 修改时间</span>
</div>
<hr>
<?php
function listDirectoriesAndFiles($dir, $indent = '') {
    $result = '';
 
    // 扫描当前目录下的文件和目录
    $files = scandir($dir);
 
    $directories = [];
    $filesList = [];
 
    foreach ($files as $file) {
        if ($file === '.' || $file === '..') {
            continue;
        }
 
        $filePath = $dir . '/' . $file;
 
        if (is_dir($filePath)) {
            // 如果是目录，将目录名添加到 $directories 数组
            $directories[] = $file;
        } else {
            // 如果是文件，将文件名添加到 $filesList 数组
            $filesList[] = $file;
        }
    }
 
    // 对目录和文件列表进行排序
    sort($directories);
    sort($filesList);
 
    // 输出目录列表
    foreach ($directories as $directory) {
        $result .= '<div class="directory" onclick="toggleDirectory(this)">';
        $result .= $indent . '<span class="directory-icon">&#128194;</span>' . $directory . '->';
        $result .= '</div>';
        $result .= '<div class="collapsed">';
        $subDirectoriesAndFiles = listDirectoriesAndFiles($dir . '/' . $directory, $indent . '<span class="indent"></span>');
        $result .= $subDirectoriesAndFiles;
        $result .= '</div>';
    }
 
    // 输出文件列表
    foreach ($filesList as $file) {
        $filePath = $dir . '/' . $file;
        $fileSize = filesize($filePath);
        $fileSizeFormatted = formatFileSize($fileSize);
        $fileModified = date("Y-m-d H:i:s", filemtime($filePath));
        $result .= '<div class="file">' . $indent . '<a href="' . $filePath . '" target="_blank">' . $file . '</a>';
        $result .= '<span style="float: right;">' . $fileModified . '</span>';
        $result .= '<span class="file-size" style="float: right;">' . $fileSizeFormatted . '</span>';
        $result .= '</div>';
    }
    $result .= '<br>';
    return $result;
}
 
function formatFileSize($size) {
    $units = array('B', 'KB', 'MB', 'GB', 'TB');
    $i = 0;
    while ($size >= 1024 && $i < 4) {
        $size /= 1024;
        $i++;
    }
    return round($size, 2) . $units[$i];
}
 
// 获取当前目录路径
$dir = './';
 
// 获取当前目录下的所有目录和文件
$directoriesAndFiles = listDirectoriesAndFiles($dir);
 
// 输出目录和文件列表
echo $directoriesAndFiles;
?>
 
</div>
 
</body>
</html>