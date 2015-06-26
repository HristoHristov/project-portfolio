<?php

class ProjectController extends \BaseController {
    private $projectModel;
    public function __construct() {
        $this->projectModel = new ProjectModel();
    }

	public function home()
	{
        if(Session::get('userId') === null) {
            return Redirect::to('/user/login');
        }
        return View::make('homePage');
	}

	public function store()
	{
            $projectName = Input::get('project-name');
            $error = $this->projectModel->saveProjectName($projectName);
            return Redirect::to(URL::to('/') . '/project/repository')->withErrors($error);
	}

    public function makeDirectory($inputPath) {
        $name = Input::get('directory-name');
        $path = str_replace('|', '/', $inputPath);
        $result = $this->projectModel->makeDir($path, $name);

        if(!$result) {
            return Redirect::to('/project/' . $inputPath . '/repository');
        }
    }

    public function portfolioIndex() {
        $queryResult = $this->projectModel->getProjects();
        return View::make('projectResource', array('queryResult' => $queryResult, 'resource' => 'portfolio'));
    }

    public function repositoryIndex() {
        $queryResult = $this->projectModel->getProjects();
        return View::make('projectResource', array('queryResult' => $queryResult, 'resource' => 'repository'));
    }

    public function editRepositoryIndex() {
        $queryResult = $this->projectModel->getProjects();
        return View::make('projectResource', array('queryResult' => $queryResult, 'resource' => 'repository/edit'));
    }

    public function projectRepository($folder, $edit=null) {
        $path = str_replace('|', '/', $folder);
        $pathSplit = explode('/', $path);


        if(end($pathSplit) == '..') {
            array_splice($pathSplit, (count($pathSplit) - 2), 2);
            $path = implode('/', $pathSplit);
        }
        $directoryName = end($pathSplit);
        if(end($pathSplit) == 'Repository') {
            $queryResult = $this->projectModel->getProjects();
            return View::make('projectResource', array('queryResult' => $queryResult, 'resource' => 'repository'));

        }
        $result = $this->projectModel->openProjectDirectory($path, $directoryName, $pathSplit);
        usort($result['result'], function ($a, $b) {
            return strcmp($a["name"], $b["name"]);
        });

        if($edit === 'edit' && ($result['isPrivate'] === false || Session::get('userId') === $result['userId'])) {
            return View::make('repository', array('results' => $result['result'], 'edit' => true, 'userId' => $result['userId']));
        } else {
            var_dump($result['isPrivate']);
            if($result['isPrivate'] === false || Session::get('userId') === $result['userId']) {
                return View::make('repository', array('results' => $result['result'],'userId' => $result['userId']));
            }
            return Redirect::to('/user/login');

        }

    }

    public function openFile($input) {
        $path = str_replace('|', '/', $input);


        $pathSplit = explode('/', $path);
        $result = $this->projectModel->openFile($path, end($pathSplit), $pathSplit);
        $resultPath = implode('/', array_slice($pathSplit, 4));
        if(isset($result['redirect'])) {
            return Redirect::to('/user/login');
        } else {
            if($result[0]['view'] == 'openImage') {
                return View::make($result[0]['view'], array('path' => $resultPath));
            }
            else {
                return View::make($result[0]['view'], array('result' => $result[0]['result'], 'path'=>$path));
            }
        }
    }

    public function projectPortfolio($id=1) {
        $result = $this->projectModel->getProjectPortfolio($id);
        if(!$result['loginRedirect']) {
            return View::make('portfolio', array('id' => $id, 'pictures' => $result['result'], 'userId' => $result['userId'], 'showSlider' => $result['showSlider']));
        }
        return Redirect::to('/user/login');

    }
    public function uploadPortfolios($id) {
        $files = Input::file('project-pictures');
        $errors = $this->projectModel->saveProjectPortfolio($id, $files);
        return Redirect::to(URL::to('/') . '/project/' . $id . '/portfolio');

    }


	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($inputPath)
	{
		$path = str_replace('|', '/', $inputPath);
        $newValue = Input::get('textareaValue');
        $this->projectModel->edit($path, $newValue);
        return Redirect::to(URL::to('/') . '/project/' . $inputPath . '/file/open');
	}

    public function projectSetVisibilityPublic($id) {
        $this->projectModel->projectVisibility($id, 1);
        return Redirect::to('/project/repository');
    }

    public function projectSetVisibilityPrivate($id) {
        $this->projectModel->projectVisibility($id, 0);
        return Redirect::to('/project/repository');
    }

    /**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function editName($inputPath)
	{
        $path = str_replace('|', '/', $inputPath);
        $name = Input::get('name');
        $pathSplit = explode('/', $path);
        array_splice($pathSplit, (count($pathSplit) - 1), 1);
        $previousDir = implode('/', $pathSplit);

        $newName = $previousDir . '/' . $name;
        $result = $this->projectModel->folderEditName($path, $newName);
        if(count($result['error']) === 0) {
            $path = $result['path'];
            return Redirect::to('/project/' . $path . '/repository');
        }
	}
    public function uploadFile($inputPath) {
        $path = str_replace('|', '/', $inputPath);
        $files = Input::file('files');
        $result = $this->projectModel->uploadFile($path, $files);
        if(count($result['error']) === 0) {
            return Redirect::to('/project/' . $result['path'] . '/repository');
        }
    }

    public function destroy($inputPath)
    {
        $path = str_replace('|', '/', $inputPath);
        $splitPath = explode('|', $inputPath);
        $this->projectModel->destroy($path);
        $getCurrentDir = array_splice($splitPath, count($splitPath) - 1, 1);
        $path = implode('|', $splitPath);
        return Redirect::to(URL::to('/') . '/project/' . $path . '/repository');
    }


}
