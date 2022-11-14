const show = (target) => {
    var value = target.value;

    if (value == "default") {
        document.getElementById("rate").style = "display:none";
        document.getElementById("year").style = "display:none";
        document.getElementById("genre").style = "display:none";
    }
    if (value == "rate") {
        document.getElementById("rate").style = "display:block";
        document.getElementById("year").style = "display:none";
        document.getElementById("genre").style = "display:none";
    }
    else if (value == "year") {
        document.getElementById("rate").style = "display:none";
        document.getElementById("year").style = "display:block";
        document.getElementById("genre").style = "display:none";
    }
    else if (value == "genre") {
        document.getElementById("rate").style = "display:none";
        document.getElementById("year").style = "display:none";
        document.getElementById("genre").style = "display:block";
    }
    }

    const showCondition = (target) => {
        var value = target.value;

        if (value == "film") {
            document.getElementById("genre").style = "display:block";
            document.getElementById("person").style = "display:none";
            document.getElementById("condition").style = "display:block";
        }
        else if (value == "person") {
            document.getElementById("condition").style = "display:none";
            document.getElementById("person").style = "display:block";
            document.getElementById("rate").style = "display:none";
            document.getElementById("year").style = "display:none";
            document.getElementById("genre").style = "display:none";
        }
    }