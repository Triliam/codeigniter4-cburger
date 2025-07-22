<?= $this->extend('layouts/layout_main') ?>
<?= $this->section('content') ?>
<?= $this->include('partials/page_title') ?>

<div class="container-fluid">
  <div class="row">
    <div class="col content-box p-5">
      <div class="d-flex align-items-center">
        <!-- image -->
         <div class="me-3">
          <?php if(!file_exists('assets/images/products/' . $product->image)): ?>
            <img class="img-fluid image-stock" src="<?= base_url('assets/images/products/no_image.png') ?>" alt="no_image">
          <?php else: ?>
            <img class="img-fluid image-stock" src="<?= base_url('assets/images/products/' . $product->image) ?>" alt="<?= $product->name ?>">
          <?php endif; ?>  
         </div>

         <!-- name and description -->
          <div class="flex-fill me-3">
            <h4 class="mb-0"><strong><?= $product->name ?></strong></h4>
            <p class="mb-0"><?= $product->description ?></p>
            <?php if(!$product->availability): ?>
              <span class="badge bg-danger">Indisponível</span>
            <?php endif; ?>
          </div>

          <!-- current stock -->
           <div class="text-end">
            <h5>Estoque atual</h5>
            <h3 class="<?= $product->stock <= $product->stock_min_limit ? 'text-danger' : '' ?>"><strong><?= $product->stock ?></strong></h3>
           </div>
      </div>

      <hr>

      <!-- form -->
       <div class="row">
        <div class="col">
             <?= form_open('/stocks/removesubmit') ?> 
             <input type="hidden" name="id_product" value="<?= Encrypt($product->id) ?>">
             <div class="row">
              <div class="col-sm-2 col-6 mb-3">
                <label for="text_stock" class="form-label">Quantidade</label>
                <input type="number" class="form-control text-end" name="text_stock" id="text_stock" min="0" value="<?= old('text_stock', 0) ?>">
                <?= display_error('text_stock', $validation_errors) ?>
              </div>
                <div class="col-sm-2 col-6 mb-3 align-self-center text-end">
                <p class="mb-0">Tipo de movimento</p>
                <h4>Saída de estoque</h4>
              </div>
             </div>



             <div class="row">
              <div class="col-sm-8 col-12 mb-3">
                <label for="text_reason" class="form-label">Observações</label>
                <input type="text" name="text_reason" id="text_reason" class="form-control" value="<?= old('text_reason') ?>">
              </div>
             </div>

               <div class="row">
              <div class="col-sm-4 col-12 mb-3">
                <label for="text_date" class="form-label">Data</label>
                <input type="text" name="text_date" id="text_date" class="form-control" value="<?= old('text_date', date('Y-m-d')) ?>">
                <?= display_error('text_date', $validation_errors) ?>
              </div>
             </div>
             <?php if(!empty($server_error)): ?>
              <div class="alert alert-danger mb-3 p-2">
                <?= $server_error ?>
              </div>
              <?php endif; ?>
             <div>
              <a href="<?= site_url('/stocks') ?>" class="btn btn-outline-secondary px-5"><i class="fas fa-ban me-3"></i>Cancelar</a>
              <button type="submit" class="btn btn-outline-success px-5"><i class="fas fa-check me-2"></i>Registrar Saída </button>
             </div>
             <?= form_close() ?>
        </div>
       </div>
    </div>
  </div>
</div>

<script>
  document.addEventListener('DOMContentLoaded', () => {
    flatpickr('#text_date', {
      dateFormat: 'Y-m-d H:i',
      time_24hr: true,
      enableTime: true,
      maxDate: 'today'
    })
  })
</script>

<?= $this->endSection() ?>