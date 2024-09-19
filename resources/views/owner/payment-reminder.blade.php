@extends('owner.layouts.master')
@section('content')
<main id="content" class="bg-gray-01">
   <div class="px-3 px-lg-6 px-xxl-13 py-5 py-lg-10">
    @include('flash-message.flash-message')
      <div class="mb-6">
         <h2 class="mb-0 text-heading fs-22 lh-15">Payment Reminder Email Template</h2>
      </div>
      <form action="{{ route('owner.store.payment.request') }}" method="post" enctype="multipart/form-data">
        @csrf
        <div class="row mb-6">
            <div class="col-lg-12">
               <div class="card mb-6">
                  <div class="card-body px-6 pt-6 pb-5">
                     <div class="row">
                        <div class="form-group col-md-12 px-4">
                            <input type="hidden" name="id" value="@if($paymentReminder->user_id==auth()->user()->id){{$paymentReminder?->id}} @endif">
                            <label for="paymnet_reminder_content" class="text-heading ">Content</label>
                            <textarea class="form-control form-control-lg border-0" id="paymnet_reminder_content" name="paymnet_reminder_content">
                                {{$paymentReminder?->content}}
                            </textarea>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
         <div class="d-flex justify-content-end flex-wrap">
            <button class="btn btn-lg btn-primary ml-4 mb-3" type="submit">@if(!empty($paymentReminder)) Update @else Create @endif</button>
         </div>
    </form>
   </div>
</main>
@endsection
@push('js')
<script>
    $(function(){
            ClassicEditor.create( document.querySelector( '#paymnet_reminder_content' ) ).then( editor => {
                descriptionEditor=editor;
        }).catch( error => {
        console.error( error );
        });
    })
</script>
    
@endpush