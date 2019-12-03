<?php

namespace App\Services;

use Carbon\Carbon;
use App\Models\Project\Type;
use App\Models\Project\Project;
use App\Models\Project\TaskType;
use App\Models\User\SkillSpecialty;
use App\Events\Project\PublishProjectEvent;
use App\Repositories\Project\TaskRepository;
use App\Repositories\Project\ProjectRepository;

class ProjectService
{
	protected $projectRepository;
	protected $taskRepository;

    public function __construct(ProjectRepository $projectRepository,TaskRepository $taskRepository)
    {
        $this->projectRepository = $projectRepository;
        $this->taskRepository = $taskRepository;
        $this->taskRepository->clearNotAssignedTask();
    }

    public function pluckListTypes($key = 'id', $value = 'name')
    {
        return ['' => '-- Select Project Type --'] + Type::orderBy($value)->pluck($value, $key)
            ->all() + ['other' => 'Other'];
    }

    public function pluckListSkillSpecialty($key = 'id', $value = 'name')
    {
        return SkillSpecialty::pluck($value, $key)
            ->all() + ['add_new' => 'Add New'];
    }

    public function getCurrentDateProjects()
    {
        return $this->projectRepository->getCurrentDateProjects();
    }

    public function getUserCurrentProjects($userId) {
        return $this->projectRepository->getUserCurrentProjects($userId);
    }

    public function createNewProject($fields) {
        $project = $this->projectRepository->createNewProject($fields);

        if (!$project) {
            return false;
        }

        if (isset($fields['task_ids'])) {
            $this->taskRepository->updateAssignedTaskToProject($project, $fields['task_ids']);
        }

        ProjectRepository::updateEndDate($project->id);

        return $project; 
    }

    public function updateProject(Project $project, $fields) {        
        $this->projectRepository->updateProject($project, $fields);

        ProjectRepository::updateEndDate($project->id);

        return true;
    }

    public function getSchedules()
    {
        return $this->projectRepository->getSchedules();
    }

    public function getFormDataProject(Project $project) {
        return $this->projectRepository->getFormDataProject($project);
    }

    public function eventDropProject(Project $project, $fields) {
        
        $fields['end_date'] = (new Carbon($fields['end_date']))->subDays(1)->format('Y-m-d');

        $this->projectRepository->updateStartEndDateProject($project, $fields);

        ProjectRepository::updateEndDate($project->id);

        return $project;
    }

    public function eventResizeProject(Project $project, $fields) {
        
        $fields['end_date'] = (new Carbon($fields['end_date']))->subDays(1)->format('Y-m-d');

        $this->projectRepository->updateStartEndDateProject($project, $fields);

        ProjectRepository::updateEndDate($project->id);

        return $project;
    }

    public function setPublishProject(Project $project, $fields) {
        $result = $this->projectRepository->setPublishProject($project, $fields);
        event(new PublishProjectEvent($project));

        return $result;
    }
}