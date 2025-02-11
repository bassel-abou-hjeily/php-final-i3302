

document.addEventListener("DOMContentLoaded", () => {
   const toggleMenu = document.querySelector(".toggle-menu");
   const ulMenu = document.querySelector(".ul");
   const categories = document.querySelector(".categories");
   const category = document.querySelector(".ul li.categories .category");
   const galleryNext = document.querySelector("#next");
   const galleryPrev = document.querySelector("#prev");

   if (categories && category) {
      categories.addEventListener("click", () => {
         category.style.display = category.style.display === "block" ? "none" : "block";
      });
   }

   if (toggleMenu && ulMenu) {
      toggleMenu.addEventListener("click", () => {
         toggleMenu.classList.toggle("menu-active");
         ulMenu.style.display = ulMenu.style.display === "flex" ? "none" : "flex";
      });
   }

   document.querySelectorAll(".gallery, .about, .contact, .to, .internet, .accessories, .phone, .laptop")
      .forEach((item) => {
         item.addEventListener("click", (event) => {
            if (window.innerWidth <= 991 && ulMenu) {
               ulMenu.style.display = "none";
            }
               category.style.display = "none";
          
            if (toggleMenu) toggleMenu.classList.remove("menu-active");
         });
      });

   document.querySelectorAll("#prev, #next, .toggle-menu, .prev, .next, #next-accessories, #prev-accessories, #next-phone, #prev-phone, #next-laptop, #prev-laptop")
      .forEach((element) => {
         element.addEventListener("click", (e) => e.preventDefault());
      });

   if (galleryNext) {
      galleryNext.addEventListener("click", () => {
         const lists = document.querySelectorAll(".item");
         console.log(lists);
         if (lists.length > 0) {
            document.querySelector(".slide").appendChild(lists[0]);
         }
      });
   }

   if (galleryPrev) {
      galleryPrev.addEventListener("click", () => {
         const lists = document.querySelectorAll(".item");
         if (lists.length > 0) {
            document.querySelector(".slide").prepend(lists[lists.length - 1]);
         }
      });
   }
});


// Gallery

   // document.querySelector('#next').onclick = function () {
   //    let lists = document.querySelectorAll('.item');
   //    document.querySelector('.slide').appendChild(lists[0]);
   // }
   // document.querySelector('#prev').onclick = function () {
   //    let lists = document.querySelectorAll('.item');
   //    document.querySelector('.slide').prepend(lists[lists.length - 1]);
   // }



