window.onload = () => {
    const date = document.getElementById("date");
    const vendor = document.getElementById("vendor");
    const freeCar = document.getElementById("free_car");

    date.addEventListener("submit", function (event) {
        event.preventDefault();

        const formData = new FormData(this);

        fetch("Car.php", {
            method: "post",
            body: formData
        }).then(function (response){
            return response.text();
        }).then(function (text) {
            document.getElementById("content1").innerHTML = text;
        }).catch(function (error) {
            console.error(error);
        });
    })

    vendor.addEventListener("submit", function (event) {
        event.preventDefault();

        const formData1 = new FormData(this);
        fetch("Car.php", {
            method: "post",
            body: formData1
        }).then(function (response){
            return response.json();
        }).then(function (json) {
            document.getElementById("content2").innerHTML = json;
        }).catch(function (error) {
            console.error(error);
        });
    })

    freeCar.addEventListener("submit", function (event) {
        event.preventDefault();

        const formData2 = new FormData(this);
        let xhr = new XMLHttpRequest();
        xhr.open("POST", "Car.php");
        xhr.responseType = 'document';
        xhr.send(formData2);

        xhr.onload = () => {
            document.getElementById("content3").innerHTML = xhr.responseXML.body.innerHTML;
        }
    })
}


