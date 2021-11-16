<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\StoreNewsRequest;
use App\Http\Requests\UpdateNewsRequest;
use App\Http\Resources\Admin\NewsResource;
use App\Models\News;
use App\Models\Visit;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class NewsApiController extends Controller
{
    use MediaUploadingTrait;


    public function list() {

        $visit = new Visit;
        $visit->save();
         return new NewsResource(News::with(['category'])->get());
    }

    public function index()
    {
        abort_if(Gate::denies('news_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new NewsResource(News::with(['category'])->get());
    }

    public function store(StoreNewsRequest $request)
    {
        $news = News::create($request->all());

        if ($request->input('thumb_image', false)) {
            $news->addMedia(storage_path('tmp/uploads/' . basename($request->input('thumb_image'))))->toMediaCollection('thumb_image');
        }

        if ($request->input('banner_image', false)) {
            $news->addMedia(storage_path('tmp/uploads/' . basename($request->input('banner_image'))))->toMediaCollection('banner_image');
        }

        if ($request->input('gallery', false)) {
            $news->addMedia(storage_path('tmp/uploads/' . basename($request->input('gallery'))))->toMediaCollection('gallery');
        }

        return (new NewsResource($news))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(News $news)
    {
        abort_if(Gate::denies('news_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new NewsResource($news->load(['category']));
    }

    public function update(UpdateNewsRequest $request, News $news)
    {
        $news->update($request->all());

        if ($request->input('thumb_image', false)) {
            if (!$news->thumb_image || $request->input('thumb_image') !== $news->thumb_image->file_name) {
                if ($news->thumb_image) {
                    $news->thumb_image->delete();
                }
                $news->addMedia(storage_path('tmp/uploads/' . basename($request->input('thumb_image'))))->toMediaCollection('thumb_image');
            }
        } elseif ($news->thumb_image) {
            $news->thumb_image->delete();
        }

        if ($request->input('banner_image', false)) {
            if (!$news->banner_image || $request->input('banner_image') !== $news->banner_image->file_name) {
                if ($news->banner_image) {
                    $news->banner_image->delete();
                }
                $news->addMedia(storage_path('tmp/uploads/' . basename($request->input('banner_image'))))->toMediaCollection('banner_image');
            }
        } elseif ($news->banner_image) {
            $news->banner_image->delete();
        }

        if ($request->input('gallery', false)) {
            if (!$news->gallery || $request->input('gallery') !== $news->gallery->file_name) {
                if ($news->gallery) {
                    $news->gallery->delete();
                }
                $news->addMedia(storage_path('tmp/uploads/' . basename($request->input('gallery'))))->toMediaCollection('gallery');
            }
        } elseif ($news->gallery) {
            $news->gallery->delete();
        }

        return (new NewsResource($news))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(News $news)
    {
        abort_if(Gate::denies('news_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $news->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
