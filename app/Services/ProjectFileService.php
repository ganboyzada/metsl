<?php

namespace App\Services;

use App\Repository\ProjectFileRepositoryInterface;
use Illuminate\Support\Facades\Storage;

class ProjectFileService
{
    public function __construct(
        protected ProjectFileRepositoryInterface $ProjectFileRepository
    ) {
    }

    public function createBulkFiles($project_id ,  $data)
    {
        \DB::beginTransaction();
        try {         
            $docs = array_map(function($file) use($project_id){
                $fileName = $file->getClientOriginalName();
                //$file->move(('storage/project'.$project_id.'/'),$fileName);
                Storage::disk('public')->putFileAs($file, 'project'.$project_id.'/'.$fileName);


                return ['name'=>$fileName , 'project_id'=>$project_id , 'type'=>$file->extension()];

            } , $data['docs']);

            $model = $this->ProjectFileRepository->create_bulk_files($docs);
            \DB::commit();
        // all good
        } catch (\Exception $e) {
            \DB::rollback();
            //dd($e);
            throw new \Exception($e->getMessage());
        }            
        return $model;
    }

}