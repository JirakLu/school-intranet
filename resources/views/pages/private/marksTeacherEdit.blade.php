@extends("layout.layout_private")

@section("content")
    <div x-data="{
            markDetailModal: false,
            markAddModal: false,
            markAddData: {},
            markDetailData: {}
        }"
         class="py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 md:px-8">
            <h1 class="text-3xl lg:text-4xl font-semibold text-gray-900">Známky</h1>
        </div>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 md:px-8">
            <!-- Replace with your content -->
            @include("components.classSelector")
            @if (isset($selected) && isset($marks))
                <div class="py-4">
                    <div class="px-4 py-5 bg-white shadow rounded-lg overflow-hidden sm:p-6">
                        <div class="shadow-md rounded-lg overflow-hidden w-full flex flex-col gap-2 md:gap-0 divide-gray-500 md:divide-y-[1px]">
                            @foreach($marks as $markInfo)
                                @include("components.gradesRowTeacher", ["markInfo" => $markInfo, "addMark" => true])
                            @endforeach
                        </div>
                    </div>
                </div>
        @endif
        <!-- /End replace -->
        </div>

        @include("components.markEditModal")
        @include("components.markAddModal")
    </div>
@endsection