@extends('backpack::layout')

@section('header')
@endsection

@section('content')
    <style>
        .message-candidate {
            background: rgba(223, 229, 121, 0.9);
            padding: 40px;
            max-width: 600px;
            margin-bottom: 10px;
        }

        .message-hiring-manager {
            background: #3c8dbc;
            padding: 40px;
            max-width: 600px;
            margin-bottom: 10px;
        }

        .messaging {
            max-width: 600px;
            margin-top: 20px;
        }

        .message-text {
            margin-top: 10px;
        }

        .message-photo {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            object-fit: cover;
            object-position: center center;
            display: inline-block;
        }

        .message-name {
            margin-left: 10px;
            display: inline-block;
        }
    </style>
    <h2 class="text-center">Коментарі</h2>
    <div class="container">
        {{--<div class="message-hiring-manager center-block">--}}
            {{--<div class="row">--}}
                {{--<div class="col-xs-8 col-md-6">--}}
                    {{--<h4 class="message-name">Менеджер 1</h4>--}}
                {{--</div>--}}
                {{--<div class="col-xs-4 col-md-6 text-right message-date">{{now()}}</div>--}}
            {{--</div>--}}
            {{--<div class="row message-text">--}}
                {{--text over here text over here text over here text over here text over here text over here text over here text over here text over here--}}
            {{--</div>--}}
            {{--<a href="https://static.addtoany.com/images/dracaena-cinnabari.jpg">--}}
                {{--<img src="https://static.addtoany.com/images/dracaena-cinnabari.jpg" class="img-thumbnail" alt="Responsive image">--}}
            {{--</a>--}}
        {{--</div>--}}
        @foreach($comments as $comment)
        <div class="message-hiring-manager center-block">
            <div class="row">
                <div class="col-xs-8 col-md-6">
                    <h4 class="message-name">{{$comment->user->name}}</h4>
                </div>
                <div class="col-xs-4 col-md-6 text-right message-date">{{$comment->created_at}}</div>
            </div>
            <div class="row message-text ">
               {{$comment->text}}
            </div>
            <a href="{{url($comment->photo)}}">
                <img src="{{url($comment->photo)}}" class="img-thumbnail" alt="Responsive image">
            </a>
        </div>
        @endforeach
        <div class="messaging center-block">
            <form action="" method="post" enctype="multipart/form-data">
                {{csrf_field()}}
                <div class="form-group">
                    <label for="exampleFormControlFile1" >Фото</label>
                    <input type="file" class="form-control-file" id="exampleFormControlFile1" name="photo" required>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="input-group">
                            <input type="text" class="form-control" name="text" required>
                            <span class="input-group-btn">
                <button class="btn btn-default" type="submit">Відправити</button>
              </span>
                    </div>
                </div>
            </div>
            </form>
        </div>
    </div>
@endsection
