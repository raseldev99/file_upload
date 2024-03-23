<?php

namespace App\Http\Controllers;

use App\Models\FileUpload;
use Illuminate\Http\Request;
use Inertia\Inertia;

class FileUploadController extends Controller
{
    public function index()
	{
		return Inertia::render('Index');
	}
	
	public function store(Request $request)
	{
		$request->validate([
			'unique_id'=> 'required|unique:file_uploads',
			'file' => 'required|file|max:10240', // 10 GB
		]);
		
		$fileName = $request->unique_id."-".$request->file->getClientOriginalName();
		$filePath = $request->file->storeAs('uploads', $fileName);
		
		FileUpload::create([
			'unique_id'=>$request->unique_id,
			'name' => $fileName,
			'path' => $filePath
		]);
	}
}
