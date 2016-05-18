<html>

<head>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.2/jquery.min.js"></script>
<title>Filter Table</title>
</head>
<style>
#myTable{
width:100%;
border-collapse:collapse;
}
#HeadRow{
background:#004C2E;
color:white;
font-weight:bold;
}
#myTable td{
padding:5px;
border:1px solid black;
text-align:left;
}
.optionsDiv {
padding-bottom:10px;
font-weight:bold;
}
#selectField{
-webkit-border-radius: 5px;
-moz-border-radius: 5px;
border-radius: 5px;
border: 1px solid #ccc;
font-size: 16px;
height: 30px;
width: 200px;
color:white;
background-color: #004C2E;
}
.odd{
background:#CCFFEB;
}
.even{
background:#99FFD6;
}
</style>


<body>
    <div class="optionsDiv">
        Filter By Position
        <select id="selectField">
            <option value="All" selected>All</option>
            <option value="Student">Student</option>
            <option value="Assistant">Assistant</option>
            <option value="Professor">Professor</option>

        </select>

    </div>
    <table id="myTable">
        <tr id="HeadRow">
            <td>First Name</td>
            <td>Last Name</td>
            <td>Age</td>
            <td>Position</td>
        </tr>

        <tr position="Student">
            <td>John</td>
            <td>John's Last name</td>
            <td>25</td>
            <td>Student</td>
        </tr>

        <tr position="Assistant">
            <td>Timmy</td>
            <td>Timmy's Last name</td>
            <td>22</td>
            <td>Assistant</td>
        </tr>

        <tr position="Professor">
            <td>Billy</td>
            <td>Billy's Last name</td>
            <td>40</td>
            <td>Professor</td>
        </tr>

        <tr position="Professor">
            <td>Eddy</td>
            <td>Eddy's Last name</td>
            <td>35</td>
            <td>Professor</td>
        </tr>

        <tr position="Professor">
            <td>Emma</td>
            <td>Emma's Last name</td>
            <td>38</td>
            <td>Professor</td>
        </tr>

        <tr position="Student">
            <td>Emily</td>
            <td>Emily's Last name</td>
            <td>20</td>
            <td>Student</td>
        </tr>

        <tr position="Assistant">
            <td>Jack</td>
            <td>Jack's Last name</td>
            <td>30</td>
            <td>Assistant</td>
        </tr>

        <tr position="Student">
            <td>Robert</td>
            <td>Robert's Last name</td>
            <td>20</td>
            <td>Student</td>
        </tr>

        <tr position="Assistant">
            <td>Danny</td>
            <td>Danny's Last name</td>
            <td>37</td>
            <td>Assistant</td>
        </tr>

        <tr position="Professor">
            <td>Erick</td>
            <td>Erick's Last name</td>
            <td>42</td>
            <td>Professor</td>
        </tr>
    </table>



<script >

$(document).ready(function() {

    function addRemoveClass(theRows) {

        theRows.removeClass("odd even");
        theRows.filter(":odd").addClass("odd");
        theRows.filter(":even").addClass("even");
    }

    var rows = $("table#myTable tr:not(:first-child)");

    addRemoveClass(rows);


    $("#selectField").on("change", function() {

        var selected = this.value;

        if (selected != "All") {

            rows.filter("[position=" + selected + "]").show();
            rows.not("[position=" + selected + "]").hide();
            var visibleRows = rows.filter("[position=" + selected + "]");
            addRemoveClass(visibleRows);
        } else {

            rows.show();
            addRemoveClass(rows);

        }

    });
});
</script>
</body>
</html>
