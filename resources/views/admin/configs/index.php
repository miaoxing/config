<?php $view->layout() ?>

<?= $block('header-actions') ?>
<a class="btn btn-success" href="<?= $url('admin/configs/new') ?>">添加配置</a>
<?= $block->end() ?>

<div class="row">
  <div class="col-xs-12">
    <!-- PAGE CONTENT BEGINS -->
    <div class="table-responsive">

      <table class="js-config-table record-table table table-bordered table-hover">
        <thead>
        <tr>
          <th>服务器</th>
          <th>名称</th>
          <th>值</th>
          <th>最后修改时间</th>
          <th class="t-6">操作</th>
        </tr>
        </thead>
        <tbody>
        </tbody>
      </table>
    </div>
    <!-- /.table-responsive -->
    <!-- PAGE CONTENT ENDS -->
  </div>
  <!-- /col -->
</div>
<!-- /row -->

<script id="action-tpl" type="text/html">
  <a href="<%= $.url('admin/configs/%s/edit', id) %>">编辑</a>
  <a class="delete-record text-danger" href="javascript:"
    data-href="<%= $.url('admin/configs/%s/destroy', id) %>">删除</a>
</script>

<?= $block('js') ?>
<script>
  require(['form', 'dataTable', 'template', 'jquery-deparam'], function (form) {
    $('.js-config-form').loadParams().update(function () {
      $recordTable.reload($(this).serialize(), false);
    });

    var $recordTable = $('.js-config-table').dataTable({
      ajax: {
        url: $.queryUrl('admin/configs.json')
      },
      columns: [
        {
          data: 'server',
          render: function (data) {
            return data || '全部';
          }
        },
        {
          data: 'name'
        },
        {
          data: 'value'
        },
        {
          data: 'updated_at'
        },
        {
          data: 'id',
          sClass: 'text-center',
          render: function (data, type, full) {
            return template.render('action-tpl', full);
          }
        }
      ]
    });

    $recordTable.deletable();
  });
</script>
<?= $block->end() ?>
