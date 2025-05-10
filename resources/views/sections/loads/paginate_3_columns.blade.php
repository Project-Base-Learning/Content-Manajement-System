@extends('sections.layouts.pagination.3_columns')

@section('title')
    <div class="relative flex flex-col items-center mb-8 space-y-2 border-b-2 border-gray-200">
        <h1 class="pb-4 text-2xl font-semibold border-b-4 border-red sm:text-3xl lg:text-4xl">{{ $section->dataset->category->category_name }} Terbaru</h1>
    </div>
@overwrite

@section('items')
    @if ($data['loads'][$section->dataset->variable_name]->isEmpty())
        <p class="text-xl text-center">Hasil tidak ditemukan</p>
    @else
        @foreach ($data['loads'][$section->dataset->variable_name] as $item)
            @include('components.category_cards.'.$section->dataset->category->card_layout)
        @endforeach
    @endif
@overwrite

@section('pagination')
    @if ($section->dataset->paginate)
        {{ $data['loads'][$section->dataset->variable_name]->appends([$section->dataset->variable_name.'_page' => $data['loads'][$section->dataset->variable_name]->currentPage()])->links() }}
    @elseif ($data['navigation']['search'])
        <div class="flex justify-center py-4 border-b-2">
            <a href="{{ route($data['navigation']['search']['slug'], ['category' => $section->dataset->category->slug]) }}" class="flex items-center gap-2 font-semibold transition-transform text-primary-500 hover:scale-105">
                See All
            </a>
        </div>
    @endif
@overwrite
