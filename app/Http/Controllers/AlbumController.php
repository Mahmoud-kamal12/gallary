<?php

namespace App\Http\Controllers;

use App\Models\Album;
use Illuminate\Http\Request;

class AlbumController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $albums = Album::WithAuth()->get()->toArray();
        return response()->json([
            "message" => "success",
            "albums" => $albums
        ]);
    }
    public function move(Request $request)
    {
        $old = Album::find($request->old);
        $new = Album::find($request->new);
        $oldFiles = $old->getMedia();
        foreach ($oldFiles as $file){
            $file->model()->associate($new);
            $file->save();
        }
        $old->delete();
        return response()->json([
            "message" => "success"
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $data = $request->only('name');
        $album = Album::create($data);
        return response()->json([
            "message" => "success",
            "album" => $album
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Album  $album
     * @return \Illuminate\Http\Response
     */
    public function show(Album $album)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Album  $album
     * @return \Illuminate\Http\Response
     */
    public function edit(Album $album)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Album  $album
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Album $album)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Album  $album
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Request $request): \Illuminate\Http\JsonResponse
    {
        $old = Album::find($request->id);
        $oldFiles = $old->getMedia();
        foreach ($oldFiles as $file){
            $file->delete();
        }
        $old->delete();
        return response()->json([
            "message" => "success"
        ]);
    }

    public function fileStore(Request $request)
    {
        $album = Album::find($request->album);
        $album->addMedia($request->file)->toMediaCollection();
        $filesUel = $album->getMedia()->pluck('original_url')->toArray();
        return response()->json([
            "message" => "successfully ",
            "url" => $filesUel[count($filesUel) - 1]
        ]);
    }

    public function getAllFiles($id){
        $filesUrls = Album::find($id)->getMedia()->pluck('original_url')->toArray();
        return response()->json([
            "urls" => $filesUrls
        ]);
    }

    public function fileDelete(Request $request)
    {
        $file = Album::find($request->album)->getMedia()->where('file_name' , $request->filename)->first();
        if ($file){
            $url = $file->getFullUrl();
            $file->delete();
            return response()->json([
                "message" => "deleted successfully ",
                "url" => $url
            ]);
        }
    }
}
