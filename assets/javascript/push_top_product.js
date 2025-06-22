async function topProduct() {
  var res = await fetch("../api/top_product.php");
  var data = await res.json();

  var heroContent = document.getElementById("top_product");
  heroContent.innerHTML = data.map((product, index) =>
        `<div class="hero-content">
            <img src="data:${product.mime_type};base64,${product.image_data}"/>
                <p>${product.name}</p>
                <div class="price-container">
                  <bdi class="price">${product.price}</bdi>
                </div>
        </div>`).join("");
  var listPrice = document.getElementsByClassName("price");
  for (var i = 0; i < listPrice.length; i++) {
    var newPrice = parseInt(listPrice[i].innerHTML, 10).toLocaleString("vi-VN");
    listPrice[i].innerHTML = newPrice + "VNĐ";
  }
}
window.onload = function () {
  topProduct();
};