<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Nori Farm</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gradient-to-br from-gray-900 to-gray-800 text-white min-h-screen font-sans">

  <!-- Navbar -->
  <header class="flex justify-between items-center px-8 py-4 bg-opacity-90">
    <h1 class="text-2xl font-bold text-white">🌱 Nori Farm</h1>
    <nav class="space-x-6 hidden md:block">
      <a href="#" class="text-gray-300 hover:text-white">Home</a>
      <a href="#" class="text-gray-300 hover:text-white">Marketplace</a>
      <a href="#" class="text-gray-300 hover:text-white">Support</a>
    </nav>
    <div class="space-x-4">
      <button class="px-4 py-1 border rounded text-white border-blue-500 hover:bg-blue-500">Sign In</button>
      <button class="px-4 py-1 bg-blue-600 hover:bg-blue-700 text-white rounded">Sign Up</button>
    </div>
  </header>

<!-- Hero Section with Background -->
<section class="relative px-10 py-32 bg-cover bg-center" style="background-image: url('https://modernfarmer.com/wp-content/uploads/2013/04/farmville-hero.jpg');">
  <div class="absolute inset-0 bg-black bg-opacity-60"></div> <!-- Overlay for readability -->

  <div class="relative z-10 max-w-4xl mx-auto text-center text-white">
    <h2 class="text-4xl md:text-5xl font-bold mb-6">Grow Virtual Crops.<br />Harvest Real Rewards.</h2>
    <p class="text-gray-200 mb-6">Enter a crop name or NFT ID to see the matched product.</p>
    <div class="flex gap-3 justify-center">
      <input id="cropInput" type="text" placeholder="e.g. Cucumber or #3" class="p-3 rounded w-1/2 text-black" />
      <button onclick="findProduct()" class="bg-blue-600 hover:bg-blue-700 px-4 py-2 rounded text-white">Find Product</button>
    </div>
  </div>
</section>

<!-- Result Section -->
<section id="result" class="px-10 pb-10 hidden">
  <h3 class="text-2xl font-semibold mb-4">Matched Product:</h3>
  <div class="bg-gray-800 rounded-lg p-6 flex flex-col md:flex-row gap-6 items-center">
    <img id="productImage" src="" class="w-48 h-48 object-cover rounded" />
    <div>
      <h4 id="productTitle" class="text-xl font-bold mb-2"></h4>
      <p id="productPrice" class="mb-2"></p>
      <a id="productLink" href="#" target="_blank" class="text-blue-400 underline">Buy Now</a>
    </div>
  </div>
</section>

<!-- Supported Crops Always Visible -->
<section class="px-10 mt-4 pb-10">
  <div class="bg-gray-800 p-6 rounded shadow-lg">
    <h3 class="text-xl font-semibold mb-4">🌽 Supported Crops</h3>
    <div id="cropList" class="flex flex-wrap gap-3 text-sm"></div>
  </div>
</section>

<!-- Product Data & Scripts -->
<script>
  const productDatabase = [
    { crop: "Tomato", title: "Fresh Organic Tomato Box", price: "19,000 KRW", image: "https://cdn.britannica.com/16/187216-050-CB57A09B/tomatoes-tomato-plant-Fruit-vegetable.jpg", buyLink: "https://mockstore.com/product/tomato" },
    { crop: "Apple", title: "Crispy Fuji Apples Pack", price: "12,000 KRW", image: "https://images.everydayhealth.com/images/diet-nutrition/apples-101-about-1440x810.jpg?sfvrsn=f86f2644_5", buyLink: "https://mockstore.com/product/apple" },
    { crop: "Cucumber", title: "Organic Green Cucumbers", price: "8,500 KRW", image: "https://www.greendna.in/cdn/shop/products/cucumber_1_600x.jpg?v=1594219681", buyLink: "https://mockstore.com/product/cucumber" },
    { crop: "Carrot", title: "Sweet Baby Carrots Pack", price: "7,000 KRW", image: "https://www.garden.eco/wp-content/uploads/2017/12/how-do-baby-carrots-grow.jpg", buyLink: "https://mockstore.com/product/carrot" },
    { crop: "Potato", title: "Golden Fresh Potatoes", price: "9,500 KRW", image: "https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQgra_540DpXPr8aYWtvwaRUCvAojGY4W7BLQ&s", buyLink: "https://mockstore.com/product/potato" },
    { crop: "Lettuce", title: "Crispy Romaine Lettuce", price: "6,800 KRW", image: "https://www.bhg.com/thmb/Xy272oKSPzsYoQzQE1uzA6r6e8Y=/1878x0/filters:no_upscale():strip_icc()/tango-oakleaf-lettuce-c6f6417e-b835c4813e1d4cbf9d11ddf09fbd2ea6.jpg", buyLink: "https://mockstore.com/product/lettuce" },
    { crop: "Spinach", title: "Organic Leafy Spinach", price: "5,500 KRW", image: "https://www.trustbasket.com/cdn/shop/articles/Spinach.webp?v=1686909241", buyLink: "https://mockstore.com/product/spinach" },
    { crop: "Strawberry", title: "Juicy Sweet Strawberries", price: "14,000 KRW", image: "https://extension.colostate.edu/wp-content/uploads/2021/04/07000-fig1.jpg", buyLink: "https://mockstore.com/product/strawberry" },
    { crop: "Broccoli", title: "Green Organic Broccoli", price: "9,800 KRW", image: "https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcS5HI921PGF_R6Kqm0ESAHt9BT9snCb1lghkQ&s", buyLink: "https://mockstore.com/product/broccoli" },
    { crop: "Onion", title: "Fresh Yellow Onions", price: "7,200 KRW", image: "https://5.imimg.com/data5/SELLER/Default/2023/5/310737604/AS/AO/PQ/156819488/fresh-yellow-onion-500x500.jpeg", buyLink: "https://mockstore.com/product/onion" },
    { crop: "Garlic", title: "Premium White Garlic", price: "8,000 KRW", image: "https://www.eatingwell.com/thmb/vc5pOEYEr7bsgQaL6fnfN9LSgmc=/1500x0/filters:no_upscale():max_bytes(150000):strip_icc()/EWL-the-best-way-to-peel-garlic-hero-01-2000-26d7671c3aab4aa5868dae601ce1bbb2.jpg", buyLink: "https://mockstore.com/product/garlic" },
    { crop: "Pumpkin", title: "Ripe Yellow Pumpkin", price: "11,000 KRW", image: "https://i0.wp.com/experience.pridemobility.com/wp-content/uploads/2020/10/pumpkin-3713158_640.jpg?fit=640%2C427&ssl=1", buyLink: "https://mockstore.com/product/pumpkin" },
    { crop: "Bell Pepper", title: "Mixed Bell Pepper Trio", price: "10,500 KRW", image: "https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTbUQM0VpHfl90zrXGQw6bV2zb3GVslvWPtsw&s", buyLink: "https://mockstore.com/product/bellpepper" },
    { crop: "Corn", title: "Sweet Yellow Corn Pack", price: "9,000 KRW", image: "https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTWksA5z2vNDx49dCX-JIPRIFlukyjrXwFglw&s", buyLink: "https://mockstore.com/product/corn" },
    { crop: "Zucchini", title: "Fresh Green Zucchini", price: "7,700 KRW", image: "https://cdn.britannica.com/96/138896-050-A640EBE8/Zucchini-vines.jpg", buyLink: "https://mockstore.com/product/zucchini" },
    { crop: "Beetroot", title: "Raw Red Beetroots", price: "8,200 KRW", image: "https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSsaHd6dMquQY_aCyNHQ_9_HS6MmAJ1LE7wPQ&s", buyLink: "https://mockstore.com/product/beetroot" },
    { crop: "Cabbage", title: "Crunchy Green Cabbage", price: "6,900 KRW", image: "https://images.squarespace-cdn.com/content/v1/60d5fe5c9e25003cd4b3b2ed/1634316438635-27FNWQSMMPRHWXB0MLGJ/green-cabbage-envato.jpg", buyLink: "https://mockstore.com/product/cabbage" },
    { crop: "Peas", title: "Sweet Green Peas Pack", price: "7,800 KRW", image: "https://chefsmandala.com/wp-content/uploads/2018/04/Green-Pea.jpg", buyLink: "https://mockstore.com/product/peas" },

     
  ];

  function findProduct() {
    const input = document.getElementById('cropInput').value.trim();

    const matchById = productDatabase.find((_, index) => input.toLowerCase() === `#${index + 1}`);
    const cropName = input.replace(/#\d+$/, '').trim().toLowerCase();
    const matchByCrop = productDatabase.find(item => item.crop.toLowerCase() === cropName);

    const match = matchById || matchByCrop;

    if (match) {
      document.getElementById('productImage').src = match.image;
      document.getElementById('productTitle').innerText = match.title;
      document.getElementById('productPrice').innerText = match.price;
      document.getElementById('productLink').href = match.buyLink;
      document.getElementById('result').classList.remove('hidden');
    } else {
      alert("No product found for: " + input);
      document.getElementById('result').classList.add('hidden');
    }
  }

  document.addEventListener("DOMContentLoaded", () => {
    const cropListContainer = document.getElementById("cropList");
    productDatabase.forEach((item, index) => {
      const tag = document.createElement("span");
      tag.className = "bg-blue-600 hover:bg-blue-700 px-3 py-1 rounded cursor-pointer";
      tag.innerText = `${item.crop} #${index + 1}`;
      tag.onclick = () => {
        document.getElementById("cropInput").value = `${item.crop} #${index + 1}`;
      };
      cropListContainer.appendChild(tag);
    });
  });
</script>

</body>
</html>
