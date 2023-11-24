$("#image_upload_form").validate({
    rules: {
        caption: {
            required: true,
            maxlength: 255,
        },
        category: {
            required: true,
        },
        image: {
            required: true,
            extension: "png|jpeg|jpg|bmp",
        },
    },
    messages: {
        caption: {
            required: "please enter an image caption",
            maxlength: "Max. 255 Characters allowed",
        },
        category: {
            required: "please select a category",
        },
        image: {
            required: "please upload an Image",
            extension: "Wrong File Extension",
        },
    },
    errorPlacement: function (error, element) {
        if (element.attr("name") == "image") {
            error.insertAfter("#image_error");
        } else {
            error.insertAfter(element);
        }
    },
});

function readFile(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function (e) {
            var validImageType = [
                "image/png",
                "image/bmp",
                "image/jpeg",
                "image/jpg",
            ];

            if (!validImageType.includes(input.files[0]["type"])) {
                var htmlPreview = '<p>Image Preview is not available</p>' + e.target.result + '" />' + "<p>" + input.files[0].name + "</p>";
            } else {
                var htmlPreview = '<img width="70%" height="300px" src="' + e.target.result + '" />' + "<p>" + input.files[0].name + "</p>";
            }

            var wrapperZone = $(input).parent();
            var previewZone = $(input).parent().parent().find(".preview-zone");
            var boxZone = $(input)
                .parent()
                .parent()
                .find(".preview-zone")
                .find(".box")
                .find(".box-body");

            wrapperZone.removeClass("dragover");
            previewZone.removeClass("hidden");
            boxZone.empty();
            boxZone.append(htmlPreview);
        };

        reader.readAsDataURL(input.files[0]);
    }
}

function reset(e) {
    e.wrap("<form>").closest("form").get(0).reset();
    e.unwrap();
}

$(".dropzone").change(function () {
    readFile(this);
});

$(".dropzone-wrapper").on("dragover", function (e) {
    e.preventDefault();
    e.stopPropagation();
    $(this).addClass("dragover");
});

$(".dropzone-wrapper").on("dragleave", function (e) {
    e.preventDefault();
    e.stopPropagation();
    $(this).removeClass("dragover");
});

$(".remove-preview").on("click", function () {
    var boxZone = $(this).parents(".preview-zone").find(".box-body");
    var previewZone = $(this).parents(".preview-zone");
    var dropzone = $(this).parents(".form-group").find(".dropzone");
    boxZone.empty();
    previewZone.addClass("hidden");
    reset(dropzone);
});
