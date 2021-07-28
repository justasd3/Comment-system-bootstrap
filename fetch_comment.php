<?php

//fetch_comment.php

$connect = new PDO('mysql:host=localhost;dbname=commentdb', 'root', '');

$query = "
SELECT * FROM comments
WHERE father_id = '0' 
ORDER BY id DESC
";

$query_count = "
SELECT * FROM comments
";

$statement = $connect->prepare($query_count);
$statement->execute();
$result = $statement->fetchAll();


echo '<div class="count">' . $statement->rowCount() . ' Comments</div>';


$statement = $connect->prepare($query);
$statement->execute();
$result = $statement->fetchAll();


$output = '';


foreach ($result as $row) {
    $post_id = $row["id"];
    $output .= '
    <section class="show_comment" id="about">
        <div class="container mt-5">
            <div class="row">
                <div class="name_field col-9">
                   ' . htmlentities($row["name"]) . '
                </div>
                <div class="date_field col-3">
                ' . htmlentities($row["created_at"]) . '
                </div>
            </div>
            <div class="comment_field card">
            ' . htmlentities($row["comment"]) . '
            </div>
            <button type="button" class="btn btn-secondary btn-block" onclick="showform(' . $row['id'] . ')">Reply</button>
            <div class="clear"></div>

        </div>
    </section>
 <div id="form-' . $row['id'] . '" class="container mt-5" style="display: none;">
        <form id="input_form-' . $row['id'] . '" method="POST">
            <div class="contact-form row">
                <div class="form-field col-sm-6">
                    <input type="text" id="email" name="email" class="input-text" placeholder="Email" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$" required>
                </div>
                <div class="form-field col-sm-6">
                    <input type="text" id="name"  name="name" class="input-text" placeholder="Name" required>
                </div>
                <div class="form-field col-sm-12">
                    <input type="text" id="comment_data" name="comment_data" class="input-text-comment" placeholder="Comment" required>
                </div>
                <div class="form-field col-sm-12">
                <input type="hidden" name="id" id="id" value="' . $row['id'] . '" />
                <input type="submit" name="submit" id="submit" class="btn btn-secondary" value="Submit" onclick="insertfunc(' . $row['id'] . ')"/>
            </div>
            </div>
        </form>
        <span id="comment_message"></span>
        <br />
        <div id="display_comment"></div>
    </div>
 </p>

</div>';
    $output .= get_reply_comment($connect, $row["id"]);
}

echo $output;

function get_reply_comment($connect, $father_id = 0)
{
    $query = "SELECT * FROM comments WHERE father_id = '" . $father_id . "' ";
    $output = '';
    $statement = $connect->prepare($query);
    $statement->execute();
    $result = $statement->fetchAll();
    $count = $statement->rowCount();
    if ($count > 0) {
        foreach ($result as $row) {
            $output .= '
            <div class="row">
                <div class="col-2"></div>
                <div class="reply_form col-10">
                    <section class="show_comment" id="about">
                        <div class="container mt-5">
                            <div class="row">
                                <div class="name_field col-9">
                                ' . htmlentities($row["name"]) . '
                                </div>
                                <div class="date_field col-3">
                                ' . htmlentities($row["created_at"]) . '
                                </div>
                                <div class="comment_field card">
                                ' . htmlentities($row["comment"]) . '
                            </div>
                        </div>
                    </section>
                </div>
           </div>
 ';
            $output .= get_reply_comment($connect, $row["id"]);
        }
        echo "<div>";
    }
    return $output;
}
