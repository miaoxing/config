<?php $view->layout() ?>

<?= $block('header-actions') ?>
<a class="btn btn-default pull-right" href="<?= $url('admin/configs') ?>">返回列表</a>
<?= $block->end() ?>

<div class="row">
  <div class="col-xs-12">
    <form class="form-horizontal js-config-form" role="form" method="post">

      <div class="form-group">
        <label class="col-lg-2 control-label" for="server">
          <span class="text-warning">*</span>
          服务器
        </label>

        <div class="col-lg-4">
          <select class="js-server form-control" type="text" name="server" id="server">
          </select>
        </div>
      </div>

      <div class="form-group">
        <label class="col-lg-2 control-label" for="name">
          <span class="text-warning">*</span>
          名称
        </label>

        <div class="col-lg-4">
          <input type="text" name="name" id="name" class="form-control" required>
        </div>

        <label class="col-lg-6 help-text" for="name">
          如db
        </label>
      </div>

      <div class="form-group">
        <label class="col-lg-2 control-label" for="configs">
          <span class="text-warning">*</span>
          JSON值
        </label>

        <div class="col-lg-4">
          <textarea class="form-control" name="configs" id="configs" rows="4" required></textarea>
        </div>

        <label class="col-lg-6 help-text" for="name">
          如 {"host":"127.0.0.1","username":"admin"}
        </label>
      </div>

      <div class="clearfix form-actions form-group">
        <input type="hidden" name="id" id="id">

        <div class="col-lg-offset-2">
          <button class="btn btn-primary" type="submit">
            <i class="fa fa-check bigger-110"></i>
            提交
          </button>
          &nbsp; &nbsp; &nbsp;
          <a class="btn btn-default" href="<?= $url('admin/configs') ?>">
            <i class="fa fa-undo bigger-110"></i>
            返回列表
          </a>
        </div>
      </div>
    </form>
  </div>
</div>

<?= $block('js') ?>
<script>
  require([
    'form',
    'validator'
  ], function (form) {
    form.toOptions($('.js-server'), <?= json_encode(wei()->config->getServerOptions()) ?>, 'value', 'name');

    $('.js-config-form')
      .ajaxForm({
        url: $.url('admin/configs/update-batch'),
        dataType: 'json',
        beforeSubmit: function (arr, $form, options) {
          return $form.valid();
        },
        success: function (ret) {
          $.msg(ret, function () {
            if (ret.code === 1) {
              window.location.href = $.url('admin/configs');
            }
          })
        }
      })
      .validate();
  });
</script>
<?= $block->end() ?>

