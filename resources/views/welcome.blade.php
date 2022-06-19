@extends('layout')

@section('styles')
    <style>
        .row {
            margin-bottom: 15px;
        }
    </style>
@endsection
@section('content')
    <div class="row">
        <div class="col-12">
            <h5>Normal</h5>
            <div id="normal-contained"></div>
            <div id="normal-outlined"></div>
            <div id="normal-text"></div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <h5>Success</h5>
            <div id="success-contained"></div>
            <div id="success-outlined"></div>
            <div id="success-text"></div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <h5>Default</h5>
            <div id="default-contained"></div>
            <div id="default-outlined"></div>
            <div id="default-text"></div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <h5>Danger</h5>
            <div id="danger-contained"></div>
            <div id="danger-outlined"></div>
            <div id="danger-text"></div>
        </div>
    </div>
@endsection
@section('scripts')
    <script type="text/javascript">
        $(document).ready(function () {
            $('#normal-contained').dxButton({
                stylingMode: 'contained',
                text: 'Contained',
                type: 'normal',
                width: 120,
                onClick() {
                    DevExpress.ui.notify('The Contained button was clicked');
                },
            });

            $('#normal-outlined').dxButton({
                stylingMode: 'outlined',
                text: 'Outlined',
                type: 'normal',
                width: 120,
                onClick() {
                    DevExpress.ui.notify('The Outlined button was clicked');
                },
            });

            $('#normal-text').dxButton({
                stylingMode: 'text',
                text: 'Text',
                type: 'normal',
                width: 120,
                onClick() {
                    DevExpress.ui.notify('The Text button was clicked');
                },
            });

            $('#success-contained').dxButton({
                stylingMode: 'contained',
                text: 'Contained',
                type: 'success',
                width: 120,
                onClick() {
                    DevExpress.ui.notify('The Contained button was clicked');
                },
            });

            $('#success-outlined').dxButton({
                stylingMode: 'outlined',
                text: 'Outlined',
                type: 'success',
                width: 120,
                onClick() {
                    DevExpress.ui.notify('The Outlined button was clicked');
                },
            });

            $('#success-text').dxButton({
                stylingMode: 'text',
                text: 'Text',
                type: 'success',
                width: 120,
                onClick() {
                    DevExpress.ui.notify('The Text button was clicked');
                },
            });

            $('#default-contained').dxButton({
                stylingMode: 'contained',
                text: 'Contained',
                type: 'default',
                width: 120,
                onClick() {
                    DevExpress.ui.notify('The Contained button was clicked');
                },
            });

            $('#default-outlined').dxButton({
                stylingMode: 'outlined',
                text: 'Outlined',
                type: 'default',
                width: 120,
                onClick() {
                    DevExpress.ui.notify('The Outlined button was clicked');
                },
            });

            $('#default-text').dxButton({
                stylingMode: 'text',
                text: 'Text',
                type: 'default',
                width: 120,
                onClick() {
                    DevExpress.ui.notify('The Text button was clicked');
                },
            });

            $('#danger-contained').dxButton({
                stylingMode: 'contained',
                text: 'Contained',
                type: 'danger',
                width: 120,
                onClick() {
                    DevExpress.ui.notify('The Contained button was clicked');
                },
            });

            $('#danger-outlined').dxButton({
                stylingMode: 'outlined',
                text: 'Outlined',
                type: 'danger',
                width: 120,
                onClick() {
                    DevExpress.ui.notify('The Outlined button was clicked');
                },
            });

            $('#danger-text').dxButton({
                stylingMode: 'text',
                text: 'Text',
                type: 'danger',
                width: 120,
                onClick() {
                    DevExpress.ui.notify('The Text button was clicked');
                },
            });
        });
    </script>
@endsection
