@if ($notifyPriced)
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="alert alert-warning text-center" role="alert" style="margin: 5px;">
                    {{ $notifyPriced }}
                </div>
            </div>
        </div>
    </div>
@endif