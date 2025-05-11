<?php

namespace App\Services;

use App\Repository\CorrespondenceFileRepositoryInterface;
use App\Repository\ProjectDocumentFilesRepositoryInterface;
use App\Repository\ProjectDrawingsRepositoryInterface;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;

class ProjectDrawingsService
{
    public function __construct(
        protected ProjectDrawingsRepositoryInterface $projectDrawingsRepository
    ) {
    }

    public function createBulkFiles($project_id ,$title , $description ,  $uploadeedfiles)
    {
        \DB::beginTransaction();
        try {         
            $docs = array_map(function($file) use($project_id,$title,$description , $uploadeedfiles ){
                $fileName = $file->getClientOriginalName();

                // Get the path to the temporary uploaded file
                $path = $file->getRealPath();

                // Use getimagesize to get dimensions
                [$width, $height] = getimagesize($path);

                Storage::disk('public')->putFileAs('project'.$project_id.'/drawings', $file, $fileName);


                return ['image'=>$fileName ,  'project_id'=>$project_id,  'title'=>$title,  'description'=>$description,  'width'=>$width,  'height'=>$height];

            } , $uploadeedfiles);

            $model = $this->projectDrawingsRepository->create_bulk_files($docs);
            \DB::commit();
        // all good
        } catch (\Exception $e) {
            \DB::rollback();
            //dd($e);
            throw new \Exception($e->getMessage());
        }            
        return $model;
    }

    public function delete($id)
    {
        try{
            return $this->projectDrawingsRepository->delete($id);
        }catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    public function all($project_id)
    {
        try{
            return $this->projectDrawingsRepository->where(['project_id'=>$project_id])->all();
        }catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    public function search_drawings($project_id , $request)
    {
        try{
            return $this->projectDrawingsRepository->searchDrawings($project_id , $request);
        }catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

}