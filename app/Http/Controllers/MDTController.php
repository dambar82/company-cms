<?php

namespace App\Http\Controllers;

use App\Mail\SendRequestMail;
use App\Models\MDT\Category;
use App\Models\MDT\Service;
use App\Http\Resources\MDT\ServiceContentResource;
use App\Models\MDT\ServiceContent;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\JsonResponse;
use App\Models\MDT\Request as NewRequest;
use Illuminate\Support\Facades\Mail;

class MDTController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/master_dig_tech/services",
     *     tags={"Master Digital Technologies"},
     *     summary="Все услуги",
     *     description="Returns a collection of services filtered.",
     *     @OA\Response(
     *         response=200,
     *         description="Successful response",
     *         @OA\JsonContent()
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="No services found",
     *         @OA\JsonContent()
     *     )
     * )
     */
    public function getServices(): AnonymousResourceCollection
    {
        $firstServices = ServiceContent::where('is_first', 1)->where('hidden', 0)->get();
        $otherServices = ServiceContent::where('is_first', 0)->where('hidden', 0)->get();

        return ServiceContentResource::collection($firstServices->merge($otherServices));
    }

    /**
     * @OA\Get(
     *     path="/api/master_dig_tech/services/{service_slug}",
     *     tags={"Master Digital Technologies"},
     *     summary="Услуга по slug",
     *     description="Returns a service resource for the specified slug.",
     *     @OA\Parameter(
     *         name="service_slug",
     *         in="path",
     *         required=true,
     *         description="Slug of the service",
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful response",
     *         @OA\JsonContent()
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Service not found",
     *         @OA\JsonContent()
     *     )
     * )
     */
    public function getServiceBySlug(string $serviceSlug): AnonymousResourceCollection
    {
        $serviceId = Service::where('slug', $serviceSlug)->pluck('id');
        $firstServices = ServiceContent::whereIn('service_id', $serviceId)
            ->where('is_first', 1)
            ->where('hidden', 0)
            ->get();
        $otherServices = ServiceContent::whereIn('service_id', $serviceId)
            ->where('is_first', 0)
            ->where('hidden', 0)
            ->get();

        return ServiceContentResource::collection($firstServices->merge($otherServices));
    }

    /**
     * @OA\Get(
     *     path="/api/services/{service_slug}/{category_slug}",
     *     tags={"Master Digital Technologies"},
     *     summary="Получить контент по услугам и категориям",
     *     description="Возвращает контент для заданной услуги и категории.",
     *     @OA\Parameter(
     *         name="serviceSlug",
     *         in="query",
     *         required=true,
     *         description="Слаг услуги",
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Parameter(
     *         name="categorySlug",
     *         in="query",
     *         required=true,
     *         description="Слаг категории",
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Успешный ответ",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 property="photos",
     *                 type="array",
     *                 @OA\Items()
     *             ),
     *             @OA\Property(
     *                 property="videos",
     *                 type="array",
     *                 @OA\Items()
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Услуга или категория не найдены"
     *     )
     * )
     */
    public function getContent(string $serviceSlug, string $categorySlug)
    {
        $serviceId = Service::where('slug', $serviceSlug)->value('id');
        $categoryId = Category::where('slug', $categorySlug)->value('id');

        $firstServices = ServiceContent::where('service_id', $serviceId)
            ->where('category_id', $categoryId)
            ->where('is_first', 1)
            ->where('hidden', 0)
            ->get();
        $otherServices = ServiceContent::where('service_id', $serviceId)
            ->where('category_id', $categoryId)
            ->where('is_first', 1)
            ->where('hidden', 0)
            ->get();

        return ServiceContentResource::collection($firstServices->merge($otherServices));
    }

    /**
     * @OA\Get(
     *     path="/api/master_dig_tech/categories",
     *     tags={"Master Digital Technologies"},
     *     summary="Все категории",
     *     description="Returns a collection of categories.",
     *     @OA\Response(
     *         response=200,
     *         description="Successful response",
     *         @OA\JsonContent()
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="No categories found",
     *         @OA\JsonContent()
     *     )
     * )
     */
    public function getCategories()
    {
        return Category::all()->select('name', 'slug');
    }

    /**
     * @OA\Get(
     *     path="/api/master_dig_tech/categories/{service_slug}",
     *     tags={"Master Digital Technologies"},
     *     summary="Все категории в выбранной услуге",
     *     description="Returns a collection of categories by service.",
     *     @OA\Response(
     *         response=200,
     *         description="Successful response",
     *         @OA\JsonContent()
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="No categories found",
     *         @OA\JsonContent()
     *     )
     * )
     */
    public  function getCategoriesByServiceSlug(string $serviceSlug)
    {
        $service = Service::where('slug', $serviceSlug)->first();

        return Category::where('service_id', $service->id)->select('name', 'slug')->get();
    }

    /**
     * @OA\Post(
     *     path="/api/master_dig_tech/send_request",
     *     tags={"Master Digital Technologies"},
     *     summary="Создать заявку на услугу",
     *     @OA\Response(
     *         response=200,
     *         description="Successful response",
     *         @OA\JsonContent()
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Request not done",
     *         @OA\JsonContent()
     *     )
     * )
     */
    public function sendRequest(Request $request): JsonResponse
    {
        $requestData = $request->validate([
            'company' => 'required|string',
            'name'=> 'required|string|min:2|max:20',
            'surname'=> 'required|string|min:2|max:20',
            'phone'=> 'required|string',
            'email'=> 'required|email',
            'budget'=> 'required|string',
            'service'=> 'required|string',
            'description' => 'required|string|min:10|max:250'
        ]);

        $requestData = NewRequest::create($requestData);
        Mail::to('zakaz@mdt-agency.ru')->send(new SendRequestMail($requestData));

        return response()->json(['message' => 'Заявка успешно создана.', 'data' => $requestData]);
    }
}
