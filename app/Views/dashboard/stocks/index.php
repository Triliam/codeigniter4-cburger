<?= $this->extend('layouts/layout_main') ?>
<?= $this->section('content') ?>
<?= $this->include('partials/page_title') ?>

<div class="container-fluid">
  <div class="row">
    <div class="col">
      <h3>Produtos</h3>

      <?php if (empty($products)): ?>
        <div class="text-center mt-5">
          <h4 class="opacity-50 mb-3">Não existem produtos cadastrados.</h4>
          <span>Clique <a href="<?= site_url('/products/new') ?>">aqui </a>para adicionar o primeiro produto!</span>
        </div>
      <?php else: ?>
        <div class="container-fluid mb-5">
          <div class="col">
            <?php foreach ($products as $product): ?>
              <?= view('partials/stock_product', ['product' => $product]) ?>
            <?php endforeach; ?>
          </div>
        </div>
      <?php endif; ?>

    </div>

  </div>

</div>


<?= $this->endSection() ?>