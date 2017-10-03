$(document).ready(function () {
    $("#selectCategory").change(function () {
        var selectedCategory = $(this).val();
        var url = '/application/play/' + selectedCategory;
        window.location = url;
        return false;
    });


    $("#letter").keypress(function (e) {
        var inputType = $('input[name="inputType"]:checked').val();
        //if it is selected by Letter
        if (inputType === 'word') {
            //If it is selected by Word and Enter key is pressed
            if (e && e.keyCode == 13) {
                checkWord($(this).val());
            }
        }
    });

    $("#letter").keyup(function (e) {
        var inputType = $('input[name="inputType"]:checked').val();
        //if it is selected by Letter
        if (inputType === 'letter') {
            checkLetter($(this).val());
            //Reset the value
            $(this).val("");
        }
    });


    //Once selected input type, it should not be changed
    $('input[name="inputType"]').change(function () {
        $(this).prop('disabled', true);
    });

    var checkLetter = function (letter) {
        //check it is pressed symbol
        if (letter.length > 0) {
            $.ajax({
                url: '/application/checkletter',
                type: 'POST',
                dataType: 'json',
                async: true,
                data: {letter: letter},
                success: function (data) {
                    var exist = data.exist;
                    var letters = data.letters;
                    $('#usedLetters').html(letters.join());
                    if (Array.isArray(exist)) {
                        if (exist.length > 0) {
                            //Letter exists
                            exist.forEach(function (key) {
                                var spanid = "#letter" + key;
                                $(spanid).html(letter);
                            });
                            $.ajax({
                                url: '/application/checkWordComplete',
                                type: 'POST',
                                dataType: 'json',
                                async: true,
                                success: function (data) {
                                    //Game is finished
                                    if (data) {
                                        $('#letter').prop('disabled', true);
                                    }
                                },
                                error: function (data) {
                                    console.log(data);

                                }
                            });
                        } else {
                            //error
                            $.ajax({
                                url: '/application/error',
                                type: 'POST',
                                dataType: 'json',
                                async: true,
                                data: {error: true},
                                success: function (data) {
                                    var imgSrc = "/img/error" + data + ".png";
                                    if ($("#showError").hasClass("hidden")) {
                                        $("#showError").removeClass('hidden');
                                    }
                                    $("#showError").attr("src", imgSrc);
                                    if (data == 5) {
                                        //Game over
                                        $('#letter').prop('disabled', true)
                                    }

                                },
                                error: function (data) {
                                    console.log(data);

                                }
                            });

                        }
                    }

                },
                error: function (data) {
                    console.log(data);

                }
            });
        }

    }

    var checkWord = function (word) {
        if (word.length > 0) {
            $.ajax({
                url: '/application/checkword',
                type: 'POST',
                dataType: 'json',
                async: true,
                data: {word: word},
                success: function (data) {
                    if (data) {
                        //word is write
                        $("#wholeWord").html(word);
                        $('#letter').prop('disabled', true);

                    } else {
                        //error
                        //Show last error img
                        var imgSrc = "/img/error5.png";
                        $("#showError").attr("src", imgSrc);
                        $("#showError").removeClass('hidden');
                        $('#letter').prop('disabled', true)

                    }
                },
                error: function (data) {
                    console.log(data);

                }
            });
        }


    }

})