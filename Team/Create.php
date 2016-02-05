<?php
/*
 *  filename:       Create.php
 */

$thisPage = "Create New Team";
$AuthRoles = ["admin", "coach"];
include_once('../phpinclude/load.php');
?>
<h1>Create New Team</h1>
<p><a href="Manage.php">Back to Manage Teams</a></p>

<p>This is an optional feature that has yet to be implemented.</p>

<!--<p>To create a new team please fill the fields below.</p>
<form>
    <label class="season">Select Season: </label>
    <select id="seasonDDL">
        <?php
        $stmt = $conn->prepare("SELECT Season_Description FROM season");
        $stmt->execute();

        $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
        foreach ($stmt->fetchAll() as $r) {
            echo "<option>";
            echo $r['Season_Description'];
            echo "</option>";
        }
        ?>
    </select>
    <br/>

    <label class="">Select Sport: </label>
    <select id="sportDDL">
        <?php
        $stmt = $conn->prepare("SELECT Sport FROM sport");
        $stmt->execute();

        $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
        foreach ($stmt->fetchAll() as $r) {
            echo "<option>";
            echo $r['Sport'];
            echo "</option>";
        }
        ?>
    </select>
    <br/>
    
    <label class="">Select Division: </label> 
    <select id="divisionDDL">
        <?php
        $stmt = $conn->prepare("SELECT DivisionName FROM team_division");
        $stmt->execute();

        $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
        foreach ($stmt->fetchAll() as $r) {
            echo "<option>";
            echo $r['DivisionName'];
            echo "</option>";
        }
        ?>
    </select>
    <br/>
    
    <label class="">Select Subset: </label> 
    <textarea name="TeamSubset" rows="10" cols="5">
    </textarea>
    <br/>
    <input type="button" value="Create">
</form>-->
<!-- Insert Page Content Above -->
<?php
include_once('../phpinclude/sidebar.php');
include_once('../phpinclude/footer.php');
?>
