<?php
  $page_title = 'All Session Logs';
  require_once('includes/load.php');
  // Checkin What level user has permission to view this page
  page_require_level(2);
  $session_logs = find_all('session_logs'); // Changed function to fetch session_logs
?>
<style>
  .session-logs {
    border-radius: 8px;
  }
</style>
<?php include_once('layouts/header.php'); ?>
<div class="row">
  <div class="col-md-12">
    <?php echo display_msg($msg); ?>
  </div>
  <div class="col-md-12">
    <div class="panel panel-default">
      <div class="panel-heading clearfix">
        <div class="pull-right">
          <!-- Removed the Add New button as it doesn't apply for session logs -->
        </div>
        <div class="pull-left">
          <input type="text" id="search" class="form-control" placeholder="Search...">
        </div>
      </div>
      <div class="panel-body">
        <table class="table table-bordered session-logs">
          <thead>
            <tr>
              <th class="text-center" style="width: 50px;">#</th>
              <th> Session ID</th>
              <th> Data </th>
              <th class="text-center" style="width: 10%;"> Created At </th>
            </tr>
          </thead>
          <tbody id="table-body">
            <?php foreach ($session_logs as $log):?>
              <tr>
                <td class="text-center"><?php echo $log['id'];?></td>
                <td> <?php echo remove_junk($log['session_id']); ?></td>
                <td> <?php echo remove_junk($log['data']); ?></td>
                <td class="text-center"> <?php echo $log['created_at']; ?></td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
<?php include_once('layouts/footer.php'); ?>
<script>
  // Add event listener for input in the search bar
  document.getElementById('search').addEventListener('input', function() {
    var searchText = this.value.toLowerCase();
    var rows = document.querySelectorAll('#table-body tr');

    rows.forEach(function(row) {
      var cells = row.getElementsByTagName('td');
      var found = false;
      
      for (var i = 0; i < cells.length && !found; i++) {
        var cellText = cells[i].textContent.toLowerCase();
        if (cellText.indexOf(searchText) > -1) {
          found = true;
        }
      }
      
      row.style.display = found ? '' : 'none';
    });
  });
</script>
