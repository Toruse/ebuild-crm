<div class="modal fade bs-example-modal-lg modal-fullscreen" id="indexSchedule" tabindex="-1" role="dialog" aria-labelledby="indexScheduleLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="indexScheduleLabel">View/Edit Schedule Templates</h4>
            </div>
            <div class="modal-body iframe-modal-body">
                <div class="row iframe-container">
                    <iframe class="col-lg-12" style="padding: 0px; border: 0px;" src="{{ route('schedules.index', ['modal' => '1']) }}" allowfullscreen></iframe>    
                </div>
            </div>
        </div>
    </div>
</div>