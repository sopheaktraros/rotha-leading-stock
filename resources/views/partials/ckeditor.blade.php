@push('plugin')
    <script src="{{ url('/plugins/ckeditor/ckeditor.js') }}"></script>
    <link href="{{ url('/plugins/ckeditor/contents.css') }}"/>
@endpush
@push('scripts')
    <script src="{{ url('/plugins/ckeditor/adapters/jquery.js') }}"></script>
    <script src="{{ mix('/js/ckeditor.js') }}"></script>
@endpush
