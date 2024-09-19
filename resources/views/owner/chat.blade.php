@extends('owner.layouts.master')
@push('css')
<link rel="stylesheet" href="{{asset('traveller-assets/css/chat.css')}}" rel="text/css">
@endpush
@section('content')
    <section class="message-area">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="chat-area">
                        <!-- chatlist -->
                        <div class="chatlist">
                            <div class="modal-dialog-scrollable">
                                <div class="modal-content">
                                    <div class="chat-header">
                                        <div class="msg-search">
                                            <input type="text" class="form-control" id="inlineFormInputGroup" placeholder="Search" aria-label="search">
                                            {{-- <a class="add" href="#"><img class="img-fluid" src="https://mehedihtml.com/chatbox/assets/img/add.svg" alt="add"></a> --}}
                                        </div>
                                    </div>
                                    <div class="modal-body">
                                        <!-- chat-list -->
                                        <div class="chat-lists">
                                            <div class="tab-content" id="myTabContent">
                                                <div class="tab-pane fade show active" id="Open" role="tabpanel" aria-labelledby="Open-tab">
                                                    <!-- chat-list -->
                                                    <div class="chat-list">
                                                        
                                                    </div>
                                                    <!-- chat-list -->
                                                </div>
                                            </div>
                                        </div>
                                        <!-- chat-list -->
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- chatlist -->
                        <!-- chatbox -->
                        <div class="chatbox" id="chatbox">
                            <div class="modal-dialog-scrollable">
                                <div class="modal-content">
                                    <div class="msg-head">
                                        <div class="row">
                                    
                                        </div>
                                    </div>
                                    <div class="modal-body">
                                        <div class="msg-body" id="msg-body">
                                           
                                        </div>
                                    </div>
                                    <div class="send-box">
                                        <form id="sendMessage">
                                            <input type="text" class="form-control input-field" aria-label="message…"  placeholder="Write message…" name="message">
                                            <input type="text" class="reciver_id" name="reciver_id" value="${id}" hidden>
                                            <button type="submit" disabled onclick="sendMessage(event)"><i class="fa fa-paper-plane" aria-hidden="true"></i> Send</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- chatbox -->
                </div>
            </div>
        </div>
        </div>
    </section>
    <!-- char-area -->
@endsection
@push('js')
<script src="{{asset('chat/user.js')}}"></script>
<script src="{{asset('chat/chat.js')}}"></script>
@endpush
