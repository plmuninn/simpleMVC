<?php
/**
 * Created by IntelliJ IDEA.
 * User: loki
 * Date: 27.04.12
 * Time: 07:43
 *
 */

if(isset($_GET["topic_id"])):
    $edit_topic= $this->model->getById(array("id_topic"=>HTMLManager::cleanInput($_GET["topic_id"])));

    $catArray = array();

    $cat = new CategoryModel();
    $cat = $cat->getAll();

        $first_post = new PostModel();
        $first_post = $first_post->getById(array("id_post" =>$edit_topic->first_topic));

 if(Application::isAdmin()){
    foreach($cat as $key => $value){
        $catArray[$value->name] =$value->id_category;
    }
 }

    ?>
<fieldset>
    <legend>Edytuj temat:</legend>
    <form method="post">
        <input type="hidden" name="topic_id" value="<?php echo HTMLManager::cleanInput($_GET['topic_id'])?>"/>
        <label for="name">Nazwa: </label><input id="name" type="text" name="name" value="<?php echo $edit_topic->title ;?>" /><br />
        <br />
        <label for="value">Treść: </label><textarea id="value" rows="10" cols="40" name="value"><?php echo $first_post->value; ?></textarea><br />
        <?php
        if(Application::isAdmin()){
        echo HTMLManager::makeSelect(
    array(
        'name'=>'category',
        'id'=>'category',
        'label'=>'Kategoria:',
        'selected' =>$edit_topic->category_id_category,
        'values'=>$catArray,
    )
);}
 else{ ?>

      <input type='hidden' name='category' value='<?php echo $edit_topic->category_id_category;?>' />

       <?php }
       ?>
        <br />
        <input type="submit" value="Zapisz" class="submit" name="topic-edit" />
    </form>
</fieldset>
<?php
else:
    $this->redirectToOther("user"."list");
endif;