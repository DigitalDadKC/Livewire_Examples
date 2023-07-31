<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>World Countries</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
    @livewireStyles
</head>
<body>
    <div class="container">
        <div class="row" style="margin-top: 45px">
            <div class="col-md-12 offset-md-3">
                <h4>World Countries</h4>
                @livewire('countries')
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-Fy6S3B9q64WdZWQUiU+q4/2Lc9npb8tCaSX9FK7E8HnRr0Jz8D6OP9dO5Vg3Q9ct" crossorigin="anonymous"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    @livewireScripts
    <script>
        window.addEventListener('OpenAddCountryModal', function() {
            $('.addCountry').find('span').html('');
            $('.addCountry').find('form')[0].reset();
            $('.addCountry').modal("show");
        });
        window.addEventListener('CloseAddCountryModal', function() {
            $('.addCountry').find('span').html('');
            $('.addCountry').find('form')[0].reset();
            $('.addCountry').modal('hide');
        });
        window.addEventListener('OpenEditCountryModal', function(event) {
            $('.editCountry').find('span').html('');
            $('.editCountry').modal('show');
        });
        window.addEventListener('CloseEditCountryModal', function(event) {
            $('.editCountry').find('span').html('');
            $('.editCountry').find('form')[0].reset();
            $('.editCountry').modal('hide');
        });
        window.addEventListener('SwalConfirm', function(event) {
            swal({
                title: event.detail.title,
                text: event.detail.html,
                buttons: {
                    cancel: {
                        text: "Cancel",
                        visible: true,
                        color: '#d33',
                        className: 'btn-danger'
                    },
                    confirm: {
                        text: "Delete!",
                        visible: true,
                        className: 'btn-primary'
                    }
                },
                width: 300,
                closeOnClickOutside: false,
                closeOnEsc: false
            }).then(function(result) {
                if(result) {
                    window.livewire.emit('delete', event.detail.id);
                }
            })
        });
        window.addEventListener('deleted', function(event) {
            alert("Country record has been deleted");
        });
        window.addEventListener('swal:deleteCountries', function(event) {
            swal({
                title: event.detail.title,
                text: event.detail.html,
                buttons: {
                    cancel: {
                        text: "Close",
                        visible: true,
                        color: '#d33',
                        className: 'btn-danger'
                    },
                    confirm: {
                        text: "Delete All!",
                        visible: true,
                        className: 'btn-primary'
                    }
                },
                width: 300,
                closeOnClickOutside: false,
                closeOnEsc: false
            }).then(function(result){
                if(result) {
                    window.livewire.emit('deleteCheckedCountries', event.detail.checkedIDs);
                }
            });
        });
    </script>
</body>
</html>