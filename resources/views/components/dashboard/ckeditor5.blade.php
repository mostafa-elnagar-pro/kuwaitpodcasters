@props(['name', 'lang', 'value' => '', 'id' => null, 'height' => '400px'])

@php
    $elementID = $id ?? $name . '-' . $lang->abbr;
@endphp

<textarea id="{{ $elementID }}" name="{{ $name . '[' . $lang->abbr . ']' }}">
    {{ old("body.$lang->abbr", $value) }}
</textarea>


@push('js')
    @once
        <script src="https://cdn.ckeditor.com/ckeditor5/43.2.0/ckeditor5.umd.js"></script>
        <script>
            const {
                ClassicEditor,
                CKFinder,
                CKFinderUploadAdapter,
                Essentials,
                Bold,
                Italic,
                Underline,
                Strikethrough,
                Subscript,
                Superscript,
                Font,
                Alignment,
                Link,
                List,
                BlockQuote,
                Table,
                TableToolbar,
                Image,
                ImageResize,
                ImageToolbar,
                ImageStyle,
                ImageUpload,
                MediaEmbed,
                Paragraph,
                Heading,
                Highlight,
            } = CKEDITOR;

            const plugins = [
                CKFinder, CKFinderUploadAdapter, Essentials, Bold, Italic, Underline, Strikethrough, Subscript,
                Superscript,
                Font, Alignment, Link, List, BlockQuote, Table, TableToolbar, Image, ImageResize,
                ImageToolbar, ImageStyle, ImageUpload, MediaEmbed, Paragraph, Heading, Highlight,
            ];

            const image = {
                resizeUnit: 'px',
                toolbar: ['imageStyle:full', 'imageStyle:side', 'resizeImage'],
                styles: [
                    'full',
                    'side'
                ],
                resizeOptions: [{
                        name: 'resizeImage:original',
                        label: 'Original',
                        value: null
                    },
                    {
                        name: 'resizeImage:50',
                        label: '50%',
                        value: '50'
                    },
                    {
                        name: 'resizeImage:75',
                        label: '75%',
                        value: '75'
                    }
                ]
            };

            const fontSize = {
                options: ['14px', '18px', '20px', '22px', '24px', '32px', '48px', '64px'],
                supportAllValues: true
            }

            const toolbar = [
                'heading', '|', 'bold', 'italic', 'underline', 'strikethrough', 'subscript', 'superscript',
                '|',
                'fontSize', 'fontFamily', 'fontColor', 'fontBackgroundColor', '|',
                'alignment', '|', 'bulletedList', 'numberedList', 'blockQuote', '|',
                'insertTable', 'link', 'imageUpload', 'mediaEmbed', '|',
                'undo', 'redo', 'highlight', 'sourceEditing'
            ];

            const fontFamily = {
                options: ['default', 'Arial, Helvetica, sans-serif', 'Courier New, Courier, monospace',
                    'Georgia, serif', 'Cairo, sans-serif'
                ],
                supportAllValues: true
            }

            const table = {
                contentToolbar: ['tableColumn', 'tableRow', 'mergeTableCells']
            }

            const alignment = {
                options: ['left', 'center', 'right', 'justify']
            }
        </script>
    @endonce

    <script>
        
        ClassicEditor
            .create(document.querySelector("#{{ $elementID }}"), {
                contentsCss: ['https://fonts.googleapis.com/css2?family=Cairo:wght@400;700&display=swap'],
                plugins,
                toolbar,
                fontSize,
                fontFamily,
                alignment,
                table,
                image,
                ckfinder: {
                    uploadUrl: "{{ route('admin.ckeditor.uploadMedia', ['_token' => csrf_token()]) }}"
                },
                mediaEmbed: {
                    previewsInData: true
                },
                language: "{{ $lang->abbr }}",
            })
            .then(editor => {
                // console.log('Editor was initialized successfully.', editor);
            })
            .catch(error => {
                // console.error('Error occurred while initializing the editor:', error);
            });
    </script>
@endpush


@once
    @push('css')
        <link rel="stylesheet" href="https://cdn.ckeditor.com/ckeditor5/43.2.0/ckeditor5.css">
        <style>
            .ck-content {
                height: {{ $height }};
            }
        </style>
    @endpush
@endonce
