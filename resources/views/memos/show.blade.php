@extends('layout')

@section('content')
    <div>
        {{ $memo->body }}
    </div>
    <div>
        created: {{ $memo->formatted_created_at }}
    </div>
    <div>
        updated: {{ $memo->formatted_updated_at }}
    </div>
    <div>
        <a href="{{ route('memos.file') }}">ファイルをダウンロード</a>
    </div>
    
    <p><a href="{{ route('memos.edit', [ 'memo' => $memo ]) }}">編集</a></p>
    <p><a href="{{ route('memos.index') }}">戻る</a></p>

    <!-- URL taken from https://stackoverflow.com/a/14061033 -->
    <form action="https://s3-{{ getenv('AWS_REGION') }}.amazonaws.com/{{ getenv('AWS_S3_BUCKET') }}/" id="s3dropzone" class="dropzone">
        <div class="fallback">
            <input name="file" type="file" multiple />
        </div>
    </form>
@endsection

@section('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.4.0/min/dropzone.min.js"></script>
    <script type="text/javascript">
        // Make AJAX POST requests work with laravel. See https://stackoverflow.com/a/47806189
        $.ajaxSetup({
            // jQuery 1.5 より前
            beforeSend: function(xhr, type) {
                if (!type.crossDomain) {
                    xhr.setRequestHeader('X-CSRF-Token', $('meta[name="csrf-token"]').attr('content'));
                }
            },
        });

        //jQuery(document).ready(function($) {
            //var uploader = new Dropzone('#s3dropzone', {
            Dropzone.options.s3dropzone = {
                url: $('#s3dropzone').attr('action'),
                method: "post",
                //acceptedFiles: "image/png, image/jpeg, image/jpeg",
                autoProcessQueue: true,
                maxfiles: 5,
                timeout: null,
                parallelUploads: 3,
                maxThumbnailFilesize: 8, // 3MB
                thumbnailWidth: 150,
                thumbnailHeight: 150,
                /**
                 *
                 * @param object   file https://developer.mozilla.org/en-US/docs/Web/API/File
                 * @param function done Use done('my error string') to return an error
                 */
                accept: function(file, done) {
                    file.postData = [];
                    $.ajax({
                        url: "{{ route('request-s3-file-signature') }}",
                        headers: {
                            'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content'),
                        },
                        data: {
                            filename: file.name,
                            memoId: {{ $memo->id }},
                        },
                        type: 'POST',
                        dataType: 'json',
                        success: function(response) {
                            if ( !response.success )
                                done(response.message);

                            delete response.success;
                            file.custom_status = 'ready';
                            file.postData = response;
                            file.s3 = response.key;
                            $(file.previewTemplate).addClass('uploading');
                            done();
                        },
                        error: function(response) {
                            file.custom_status = 'rejected';
                            if (response.responseText) {
                                response = JSON.parse(response.responseText);
                            }
                            if (response.message) {
                                done(response.message);
                                return;
                            }
                            done('error preparing the upload');
                        }
                    });
                },
                /**
                 * Called just before each file is sent.
                 * @param object   file https://developer.mozilla.org/en-US/docs/Web/API/File
                 * @param object   xhr
                 * @param object   formData https://developer.mozilla.org/en-US/docs/Web/API/FormData
                 */
                sending: function(file, xhr, formData) {
                    $.each(file.postData, function(k, v) {
                        formData.append(k, v);
                    });
                    formData.append('Content-type', 'application/octet-stream');
                    // formData.append('Content-length', '');
                    //formData.append('acl', 'public-read');
                    formData.append('acl', 'private');
                    formData.append('success_action_status', '200');
                },
                /*
                * The file has been uploaded successfully.
                */
                success: function(file) {
                    console.log(file.s3);
                    $.ajax({
                        url: "{{ route('memos.file_uploaded', [ 'memo' => $memo ]) }}",
                        headers: {
                            'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content'),
                        },
                        data: {
                            memoId: {{ $memo->id }},
                            s3: file.s3,
                        },
                        type: 'POST',
                        dataType: 'json',
                        success: function(response) {
                            if ( !response.success )
                                done(response.message);

                            delete response.success;
                            
                            console.log('success');
                        },
                        error: function(response) {
                            if (response.responseText) {
                                response = JSON.parse(response.responseText);
                            }
                            if (response.message) {
                                console.log(response.message);
                                return;
                            }
                            console.log('error saving file');
                        }
                    });
                }
            //});
            };
        //});
    </script>    
@endsection