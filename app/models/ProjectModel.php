<?php
class ProjectModel {
    public function saveProjectName($projectName) {
        echo 'Vliza';
        $validator = Validator::make(
                array('project-name' => $projectName),
                array('project-name' => 'regex:/[A-z0-9-_]{4,50}$/')
        );
        $userId = Session::get('userId');
        if($userId !== null) {
            $querySelect = DB::select('SELECT * FROM projects WHERE project_name=?', array($projectName));
            if(count($querySelect) === 0) {
                if(!$validator->fails()) {
                    if(DB::insert('INSERT INTO projects(project_name, project_user_id, project_isPublic) VALUES(?, ?, ?)',array($projectName, $userId, 0))) {
                        echo 'Save';
                        mkdir(public_path() . '/Repository/' . $projectName);
                        return [];
                    }
                }
                return array('errors' => array('Invalid Folder format'));

            }
            else {
                return array('errors' => array('File or folder Exist'));
            }
        }
        else {
            echo 'Error';
        }
        //return ['Project name already exist'];
    }

    public function projectVisibility($id, $isPublic) {
        $sql = DB::update('UPDATE projects SET project_isPublic=? WHERE project_id=?', array($isPublic, $id));
    }
    public function getProjects() {
        $userId = Session::get('userId');
        $result = DB::table('projects')->select('project_id', 'project_name', 'project_isPublic')->where('project_user_id', $userId)->get();
        return $result;
    }
    public function saveProjectPortfolio($id, $files) {
        $arrValues = array();

        foreach ($files as $file) {
            $fileName = $file->getClientOriginalName();
            $success = $file->move(public_path() . '/PortfolioImages' , $fileName);
            if($success) {
                $arrValues[] = ['project_id' => $id, 'picture_name' => $fileName]; //Change project Id
            }
            else {
                break;
            }
        }
        if(DB::table('pictures')->insert($arrValues)) {
            echo 'Save';
        }
        else {
            'No';
        }
    }

    public function uploadFile($path, $files) {
        foreach ($files as $file) {
            $fileName = $file->getClientOriginalName();
            $success = $file->move($path , $fileName);
            if(!$success) {
                return  array('error' => 'Error');
            }
        }
        return array('path' => str_replace('/', '|', $path), 'error' => []);

    }

    public function getProjectPortfolio($id) {
	$showSlider = true;
        $result = DB::select('SELECT * FROM pictures LEFT JOIN  projects ON pictures.project_id=projects.project_id WHERE projects.project_id=?', array($id));
        if(count($result) === 0) {
	  $result = DB::select('SELECT * FROM projects WHERE project_id=?', array($id));
	  $showSlider = false;
	  $isPublic = (bool)$result[0]->project_isPublic;
	  $userId = $result[0]->project_user_id;
        }
        else {
	  $isPublic = (bool)$result[1]->project_isPublic;
	  $userId = $result[1]->project_user_id;
        }
        if($isPublic || Session::get('userId') === $userId) {
            return array('result' => $result, 'loginRedirect' => false, 'userId' => $userId, 'showSlider' => $showSlider);
        }
        return array('result' => [], 'loginRedirect' => true, 'userId' => $userId);
    }

    public function openProjectDirectory($path, $directoryName, $pathFolders) {
        $indexOfProject = array_search('Repository', $pathFolders);
        if($indexOfProject !== false) {
            $projectName = $pathFolders[$indexOfProject + 1];
            $query = DB::select('SELECT * FROM projects WHERE project_name=?', array($projectName));
            //if(array_search())
            $isPublic = (bool)$query[0]->project_isPublic;
            $userId = $query[0]->project_user_id;
            var_dump($userId);
            $result = array();
            if($isPublic || (Session::get('userId') === $userId)) {
                var_dump($isPublic);
                if($dir = opendir($path)) {
                    while (($file = readdir($dir)) !== false){
                        if(is_dir($path . '/'. $file)){
                            if(!($file == '.' || $file == '..')) {
                                $result[] = ['name' => $file, 'path' => $path . '/' . $file, 'isDir' => true, 'directoryName' => $directoryName, 'directoryNamePath' => $path, 'delete' => true];
                            } else {
                                $result[] = ['name' => $file, 'path' => $path . '/' . $file, 'isDir' => true, 'directoryName' => $directoryName, 'directoryNamePath' => $path, 'delete' => false];
                            }

                        }
                        else {
                            $result[] = ['name' => $file, 'path' => $path . '/' . $file, 'isDir' => false, 'directoryName' => $directoryName, 'directoryNamePath' => $path, 'delete' => true];
                        }
                    }
                    closedir($dir);
                }
                return array('result' => $result, 'error' => [], 'userId' => $userId, 'isPrivate' => !$isPublic);
            }
            return array('result' => [], 'error' => [], 'isPrivate' => !$isPublic, 'userId' => $userId);

        }

    }
    public function openFile($path, $fileName=null, $pathFolders) {
        $indexOfProject = array_search('Repository', $pathFolders);
        if($indexOfProject !== false) {
            $projectName = $pathFolders[$indexOfProject + 1];
            $query = DB::select('SELECT * FROM projects WHERE project_name=?', array($projectName));
//            echo $query[0]->project_isPublic;

            $isPublic = (bool)$query[0]->project_isPublic;
            $userId = $query[0]->project_user_id;
            var_dump($userId);
            $result = array();
            if ($isPublic || (Session::get('userId') === $userId)) {
                $result = array();
                $info = new SplFileInfo($path);
                $textFileType = ['php', 'js', 'txt', 'html', 'css', 'xml', 'json', 'xhtml', 'rtf', 'info'];
                $imageFileType = ['png', 'jpe', 'jpeg', 'jpg', 'gif', 'bmp', 'ico', 'tiff', 'tif', 'svg', 'svgz'];
                $extension = $info->getExtension();
                if (in_array($extension, $textFileType)) {
                    $phpCode = (file_get_contents($path));
                    $result[] = ['result' => htmlspecialchars($phpCode), 'view' => 'openText'];

                    return $result;
                } else if (in_array($extension, $imageFileType)) {
                    $result[] = ['path' => $path, 'view' => 'openImage'];

                    return $result;
                } else {
                    header('Content-Type: application/download');
                    header('Content-Disposition: attachment; filename="' . $fileName . '"');
                    header("Content-Length: " . filesize($path));
                    $file = fopen($path, "r");
                    fpassthru($file);
                    fclose($file);
                    return [];
                }
            }

        }
        return ['redirect' => true];
    }
    public function makeDir($path, $name) {
        if(mkdir($path . '/' . $name, 0777)) {
            echo 'Dir make';
        }
        else {
            'Error';
        }
    }
    public function folderEditName($path, $newName) {
        if(rename($path, $newName)) {
            return array('path' => str_replace('/', '|', $newName), 'error' => []);
        } else {
            return array('error' => 'Error');
        }
    }

    public function edit($path, $newValue) {
        $file = fopen($path, 'w');
        fwrite($file, $newValue);
        fclose($file);
    }
    public function destroy($path) {
        if (is_dir($path)) {
            $dir_handle = opendir($path);
            if (!$dir_handle) {
                echo "error";
            } else {
                while($file = readdir($dir_handle)) {
                    if ($file != "." && $file != "..") {
                        if (!is_dir($path."/".$file))
                            unlink($path."/".$file);
                        else
                            delete_directory($path.'/'.$file);
                    }
                }
                closedir($dir_handle);
                rmdir($path);

            }
        } else {
            unlink($path);
        }

    }
}
