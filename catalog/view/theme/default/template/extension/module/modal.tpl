<?php if ($modal_path) { ?>
<div class="footer-modal-image">
    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalImage">
        Open Modal Window
    </button>
</div>

<!-- Modal -->
<div class="modal fade" id="modalImage" tabindex="-1" role="dialog" aria-labelledby="modalImageLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h5 class="modal-title text-primary text-center">Modal Image</h5>
            </div>
            <div class="modal-body text-center">
                <img src="<?php echo $modal_path; ?>" class="img-fluid" alt="Modal Image">
            </div>
        </div>
    </div>
</div>
<?php } ?>