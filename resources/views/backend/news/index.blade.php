@extends('layouts.sidebar')
@section('title', 'ข่าวสารและกิจกรรม')
@section('content')
<div class="container mx-auto px-4 py-3">
    <div class="flex flex-col sm:flex-row justify-between items-center mb-3 gap-4">
        <button type="button" id="openCreateModal" class="btn btn-success text-white shadow-md">
            <i class="fa-solid fa-plus mr-2"></i> เพิ่มข่าวสารใหม่
        </button>
    </div>

    <div class=" dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl shadow-lg overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                <thead class="bg-gray-50 dark:bg-gray-700">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                            รูปภาพ
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">หัวข้อข่าวสาร</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">วันที่สร้าง</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">สถานะ</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">การกระทำ</th>
                    </tr>
                </thead>
                <tbody id="news-table-body" class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                    @foreach ($newsItems as $news)
                    <tr id="news-{{ $news->news_id }}">
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">
                            @php
                                $images = is_array($news->image_path) ? $news->image_path : ($news->image_path ? [$news->image_path] : []);
                            @endphp
                            @if(count($images))
                                <div class="flex space-x-2">
                                    @foreach(array_slice($images,0,3) as $img)
                                        <img src="{{ asset($img) }}" 
                                            onerror="this.onerror=null;this.src='https://via.placeholder.com/150?text=No+Image';" 
                                            alt="News Image" 
                                            class="h-12 w-12 object-cover rounded-md border border-gray-200">
                                    @endforeach
                                    @if(count($images) > 3)
                                        <span class="flex items-center justify-center h-12 w-12 rounded-md bg-gray-100 text-xs text-gray-500 dark:text-gray-400">
                                            +{{ count($images) - 3 }}
                                        </span>
                                    @endif
                                </div>
                            @else
                                <span class="text-gray-400 text-xs">ไม่มีภาพ</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-white">{{ $news->title }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">{{ $news->created_at->format('d/m/Y') }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">
                            @if($news->is_active)
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                    เผยแพร่
                                </span>
                            @else
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                    ไม่ใช้งาน
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <a href="{{ route('news.detail', $news->news_id) }}" class="btn btn-info btn-sm text-white">
                                <i class="fa-solid fa-eye"></i> 
                            </a>
                            <button class="btn btn-warning btn-sm edit-btn" data-id="{{ $news->news_id }}">
                                <i class="fa-solid fa-pen-to-square"></i> 
                            </button>
                            <button class="btn btn-error btn-sm text-white delete-btn" data-id="{{ $news->news_id }}">
                                <i class="fa-solid fa-trash"></i>
                            </button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

@include('backend.news._modal')

@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        // CSRF Token
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        // Open Create Modal
        $('#openCreateModal').on('click', function() {
            $('#newsForm').trigger('reset');
            $('#modalTitle').text('เพิ่มข่าวสารใหม่');
            $('#news_id').val('');
            $('#images_preview').html('');
            $('#file_news_preview').html('');
            $('#link_news').val('');
            $('#newsModal').removeClass('hidden');
        });

        // Close Modal
        $('.close-modal').on('click', function() {
            $('#newsModal').addClass('hidden');
        });

        // Open Edit Modal
        $('body').on('click', '.edit-btn', function() {
            var newsId = $(this).data('id');
            $.get('/news/' + newsId + '/edit', function(data) {
                $('#modalTitle').text('แก้ไขข่าวสาร');
                $('#news_id').val(data.news_id);
                $('#title').val(data.title);
                $('#content').val(data.content);
                // Safe date handling (รองรับ null หรือรูปแบบไม่ใช่ ISO)
                let pd = '';
                if (data.published_date) {
                    // ถ้าเป็นรูปแบบ 'YYYY-MM-DDTHH:MM:SS' แยกได้
                    if (typeof data.published_date === 'string') {
                        if (data.published_date.includes('T')) {
                            pd = data.published_date.split('T')[0];
                        } else if (/^\d{4}-\d{2}-\d{2}$/.test(data.published_date)) {
                            pd = data.published_date; // already date string
                        } else {
                            // พยายาม parse เป็น Date แล้ว format
                            let dObj = new Date(data.published_date);
                            if (!isNaN(dObj.getTime())) {
                                pd = dObj.toISOString().split('T')[0];
                            }
                        }
                    }
                }
                $('#published_date').val(pd);
                $('#is_active').prop('checked', data.is_active);
                // Images preview (multiple)
                let imgHtml = '';
                if (Array.isArray(data.image_path) && data.image_path.length) {
                    data.image_path.forEach(function(p){
                        imgHtml += `<img src="${p}" class="h-16 w-16 object-cover rounded-md inline-block mr-2 mb-2">`;
                    });
                } else if (typeof data.image_path === 'string' && data.image_path) {
                    imgHtml = `<img src="/${data.image_path}" class="h-16 w-16 object-cover rounded-md">`;
                } else {
                    imgHtml = '<span>ไม่มีภาพ</span>';
                }
                $('#images_preview').html(imgHtml);

                // Files preview (multiple)
                let fileHtml = '';
                if (Array.isArray(data.file_news) && data.file_news.length) {
                    data.file_news.forEach(function(f){
                        const name = f.split('/').pop();
                        fileHtml += `<div><a href="/${f}" target="_blank" class="text-blue-500 underline">${name}</a></div>`;
                    });
                } else if (typeof data.file_news === 'string' && data.file_news) {
                    const name = data.file_news.split('/').pop();
                    fileHtml = `<a href="/${data.file_news}" target="_blank" class="text-blue-500 underline">${name}</a>`;
                } else {
                    fileHtml = '<span>ไม่มีไฟล์แนบ</span>';
                }
                $('#file_news_preview').html(fileHtml);
                $('#link_news').val(data.link_news);
                $('#newsModal').removeClass('hidden');
            });
        });

        // Submit Form
        $('#newsForm').on('submit', function(e) {
            e.preventDefault();
            var formData = new FormData(this);
            var newsId = $('#news_id').val();
            var url = newsId ? '/news/' + newsId : '/news';
            var method = newsId ? 'POST' : 'POST'; 
            if(newsId) {
                formData.append('_method', 'PUT');
            }


            $.ajax({
                url: url,
                method: method,
                data: formData,
                contentType: false,
                processData: false,
                success: function(response) {
                    $('#newsModal').addClass('hidden');
                    // You can either reload the page or update the table dynamically
                    location.reload(); 
                },
                error: function(xhr) {
                    // Handle errors
                    console.log(xhr.responseText);
                }
            });
        });

        // Delete News
        $('body').on('click', '.delete-btn', function() {
            var newsId = $(this).data('id');
            if (confirm('คุณแน่ใจหรือว่าต้องการลบข่าวสารนี้?')) {
                $.ajax({
                    url: '/news/' + newsId,
                    type: 'DELETE',
                    success: function(result) {
                        $('#news-' + newsId).remove();
                    }
                });
            }
        });
    });
</script>
@endsection