@extends('admin.layouts.master')
@push('title')
    Cancellation Message Email Template
@endpush
@section('content')
    <!--**********************************
        Content body start
    ***********************************-->
    <div class="content-body">
        <div class="row page-titles mx-0">
            <div class="col p-md-0">
                @include('flash-message.flash-message')
                <div class="row">
                    <div class="col-md-6">
                        <h4 style="color:black">Cancellation Message Email Template</h4>
                    </div>                             
                </div>
            </div>
        </div>
        <!-- row -->
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="form-validation">
                                <form class="form-valide" method="post" action="{{ route('admin.email.template.store.cancellation.message') }}">
                                    @csrf
                                    <div class="form-group">
									    <input type="hidden" name="id" value="{{$cancellationMessage?->id}}"> 
                                        <label for="cancelletion_messeage_content">Content</label>
                                        <!--<textarea name="cancelletion_messeage_content" id="cancelletion_messeage_content" class="form-control h-150px"> {{$cancellationMessage->content??''}}</textarea>   -->
                                    <textarea name="cancelletion_messeage_content" id="cancelletion_messeage_content" class="form-control h-150px"> {{$cancellationMessage->content??''}}</textarea>   
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-lg-8 ml-auto">
                                            <button type="submit" class="btn btn-primary">Update</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- #/ container -->
    </div>
    <!--**********************************
        Content body end
    ***********************************-->
@endsection
@push('js')
<script src="https://cdn.ckeditor.com/ckeditor5/38.0.1/classic/ckeditor.js"></script>
<script>
    $(function(){
            ClassicEditor.create( document.querySelector('#cancelletion_messeage_content') ).then( editor => {
                descriptionEditor=editor;
        }).catch( error => {
        console.error( error );
        });
    })
</script>
    
@endpush