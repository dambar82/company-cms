<?php

namespace App\Http\Controllers;

use App\Http\Resources\ImageGalleryResources;
use App\Models\ImageGallery;
use Illuminate\Http\Request;

class ImageGalleryController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/imgGallery",
     *     tags={"Abubakirov"},
     *     summary="Get all images in the gallery",
     *     description="Returns a collection of image resources filtered by project ID 2.",
     *     @OA\Response(
     *         response=200,
     *         description="Successful response",
     *         @OA\JsonContent(
     *             @OA\Property()
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="No images found for the specified project",
     *         @OA\JsonContent()
     *     )
     * )
     */
    public function index()
    {
        return ['imgGallery' => ImageGalleryResources::collection(ImageGallery::all()->where('project_id', '=', 2))];
    }

    /**
     * @OA\Get(
     *     path="/api/imgGallery/{id}",
     *     tags={"Abubakirov"},
     *     summary="Get a specific image from the gallery",
     *     description="Returns an image resource for the specified ID.",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID of the image",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful response",
     *         @OA\JsonContent(
     *             @OA\Property()
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Image not found",
     *         @OA\JsonContent()
     *     )
     * )
     */
    public function show(int $id)
    {
        return  ['imgGallery' => new ImageGalleryResources(ImageGallery::findOrFail($id))];
    }
}
