

<?php
    $url = $_POST['url'];

    include 'apis/pagespeed.php';

    $pageSpeed = new PageSpeedAPI();

    $results = $pageSpeed->get_results($url);

    $score = $results->ruleGroups->SPEED->score;

    $results = $results->formattedResults->ruleResults;
?>
<!DOCTYPE html>
<html lang="en">
<head>

  <!-- Basic Page Needs
  –––––––––––––––––––––––––––––––––––––––––––––––––– -->
  <meta charset="utf-8">
  <title>Your page title here :)</title>
  <meta name="description" content="">
  <meta name="author" content="">

  <!-- Mobile Specific Metas
  –––––––––––––––––––––––––––––––––––––––––––––––––– -->
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- FONT
  –––––––––––––––––––––––––––––––––––––––––––––––––– -->
  <link href="//fonts.googleapis.com/css?family=Raleway:400,300,600" rel="stylesheet" type="text/css">

  <!-- CSS
  –––––––––––––––––––––––––––––––––––––––––––––––––– -->
  <link rel="stylesheet" href="../css/normalize.css">
  <link rel="stylesheet" href="../css/skeleton.css">
  <link rel="stylesheet" href="../css/style.css">

  <!-- Favicon
  –––––––––––––––––––––––––––––––––––––––––––––––––– -->
  <link rel="icon" type="image/png" href="images/favicon.png">

</head>
<body>
    <?php
        if ($score >= 55) {
             $class = "failure";
        }
        if ($score >= 65) {
            $class = "mediocre";
        }
        if ($score >= 85) {
            $class = "success";
        }
    ?>
    <div class="hero reporting <?php echo $class; ?>">
        <div class="container">
          <div class="row">
            <div class="column text-center" style="margin-top: 25%">
                <span class="percent"><?php echo $score; ?><i class="sub"> / 100</i></span>
            </div>
          </div>
        </div>
    </div>

<section class="content">
    <div class="container">
        <div class="row">
            <div class="column one-tenth">

                <h2>Ruh Roh! You could improve a few things here. :(</h2>

                <table class="u-full-width">
                    <thead>
                    <tr>
                      <th>Rule</th>
                      <th>Result</th>
                      <th>Impact</th>
                    </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($results as $result) { ?>
                            <?php if ($result->ruleImpact > 0) { ?>
                                <tr>
                                  <td><?php echo $result->localizedRuleName; ?></td>
                                  <?php
                                    $args = isset($result->summary->args) ? $result->summary->args : null;
                                  ?>
                                  <td><?php echo $pageSpeed->format_summary($result->summary->format, $args); ?></td>
                                  <td><?php echo $result->ruleImpact; ?></td>
                                </tr>
                            <?php } ?>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>

    <section class="content">
        <div class="container">
            <div class="row">
                <h2>Look at the things you passed!</h2>

                <table class="u-full-width success">
                    <thead>
                    <tr>
                      <th>Rule</th>
                      <th>Result</th>
                      <th>Impact</th>
                    </tr>
                    </thead>
                    <tbody>
                <?php foreach ($results as $result) { ?>
                    <?php if ($result->ruleImpact == 0) { ?>
                        <tr>
                          <td><?php echo $result->localizedRuleName; ?></td>
                          <td><?php echo $pageSpeed->format_summary($result->summary->format, $result->summary->args); ?></td>
                          <td><?php echo $result->ruleImpact; ?></td>
                        </tr>
                    <?php } ?>
                <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>
