<?php

?>

<div class="attendance-flex catalogue-main">
    <!-- Course Code and Section Number -->
    <div class="attendance-inner-flex">
        <label for="course-code">Course Code:</label><br><br>
        <select class="selecter" name="course-code" id="course-code">
            <?php
            if ($courses != array())
                for ($i = 0; $i < count($courses); $i++)
                    foreach ($courses[$i] as $id => $code) {
                        echo "<option value='" . strval($id) . "'>" . $code . "</option>";
                    }

            ?>
        </select>
        <br><br>
        <!-- Section Number -->
        <label for="section-num">Section Number:</label><br><br>
        <input type="text" class="selecter" name="section-num" id="section-num">
    </div>

    <!-- Building and Room -->
    <div class="attendance-inner-flex" style="margin-left: 2.5em;">
        <label for="bldng">Building:</label><br><br>
        <select onchange="getRooms(this.value)" class="selecter" name="bldng" id="bldng">
            <option value="">Select a Building</option>
            <?php
            if ($buildings != array())
                for ($i = 0; $i < count($buildings); $i++)
                    foreach ($buildings[$i] as $id => $name) {
                        echo "<option value='" . strval($id) . "'>" . $name . "</option>";
                    }

            ?>
        </select>
        <br><br><br>
        <label for="room">Room:</label><br><br>
        <select class="selecter" name="room" id="room">
            <option value="">Select a Room</option>
            <!-- The options will be optained from the database using AJAX and PHP -->
            <!-- Refer to the script at the end of the page, after <body> -->
        </select>
    </div>

    <!-- Professor and Date+Time -->
    <div class="attendance-inner-flex" style="margin-left: 2.5em;">
        <label for="prof-name">Professor:</label><br><br>
        <select class="selecter" name="prof-name" id="prof-name">
            <?php
            if ($professorNames != array())
                for ($i = 0; $i < count($professorNames); $i++)
                    foreach ($professorNames[$i] as $id => $name) {
                        echo "<option value='" . strval($id) . "'>" . $name . "</option>";
                    }

            ?>
        </select>
        <br><br><br>
        <label for="datetime">Days:</label><br><br>
        <select class="selecter" name="days" id="days">
            <option value="UTH">UTH</option>
            <option value="MW">MW</option>
        </select>
    </div>

    <div class="attendance-inner-flex" style="margin-left: 2.5em;">
        <label for="datetime">Time:</label><br><br>
        <input type="time" name="datetime" id="datetime">
    </div>
</div>