document.addEventListener("DOMContentLoaded", () => {
  const uploadArea = document.getElementById("uploadArea");
  const fileInput = document.getElementById("fileInput");
  const swiperWrapper = document.getElementById("swiperWrapper");
  const previewModal = new bootstrap.Modal(
    document.getElementById("previewModal")
  );
  const previewModalTitle = document.getElementById("previewModalTitle");
  const previewModalBody = document.getElementById("previewModalBody");

  let documentCounter = 0;
  const MAX_FILE_SIZE = 20 * 1024 * 1024; // 20MB
  let swiperInstance;

  // Configuración inicial de Swiper
  function initializeSwiper() {
    if (swiperInstance) {
      swiperInstance.destroy(true, true);
    }
    swiperInstance = new Swiper(".my-swiper", {
      slidesPerView: 1.5,
      spaceBetween: 30,
      loop: false,
      autoplay: {
        delay: 3500,
        disableOnInteraction: false,
      },
      breakpoints: {
        640: { slidesPerView: 1.5 },
        1024: { slidesPerView: 4.5 },
        1280: { slidesPerView: 5.5 }, // Dejar parcialmente visibles los laterales
      },
      pagination: {
        el: ".swiper-pagination",
        clickable: true,
      },
      navigation: {
        nextEl: ".swiper-button-next",
        prevEl: ".swiper-button-prev",
      },
    });
  }

  ["dragenter", "dragover", "dragleave", "drop"].forEach((eventName) => {
    uploadArea.addEventListener(eventName, (e) => {
        e.preventDefault();
        e.stopPropagation();
    });
  });

  // Efectos Drag & Drop
  ["dragenter", "dragover"].forEach((eventName) => {
      uploadArea.addEventListener(eventName, () => uploadArea.classList.add("dragover"));
  });

  ["dragleave", "drop"].forEach((eventName) => {
      uploadArea.addEventListener(eventName, () => uploadArea.classList.remove("dragover"));
  });

  // Manejadores de archivos
  uploadArea.addEventListener("drop", (e) => handleFiles(e.dataTransfer.files));

  fileInput.addEventListener("change", (e) => {
      handleFiles(e.target.files);
      e.stopPropagation(); // Evita que el evento se propague
  });

  // Asegurar que el click no se dispare más de una vez
  uploadArea.addEventListener("click", (e) => {
      e.stopPropagation();
      if (e.target !== fileInput) {
          fileInput.click();
      }
  });

  function handleFiles(files) {
    if (!files || files.length === 0) return;

    Array.from(files).forEach((file) => {
      if (!["application/pdf", "image/jpeg", "image/png"].includes(file.type)) {
        alert("Solo se permiten archivos PDF, JPG y PNG");
        return;
      }
      if (file.size > MAX_FILE_SIZE) {
        alert("El tamaño máximo de archivo es 20MB");
        return;
      }
      documentCounter++;
      addDocumentCard(file, documentCounter);
    });

    fileInput.value = ""; // Reset input
    initializeSwiper(); // Refrescar Swiper
  }

  function addDocumentCard(file) {
    const fileURL = URL.createObjectURL(file);
    const fileType = file.type;
    const slide = document.createElement("div");
    slide.className = "swiper-slide";

    const card = document.createElement("div");
    card.className = "card h-100 document-card";

    // Título del archivo
    const title = document.createElement("div");
    title.className = "card-header border-0";
    title.innerHTML = `<h6 class="text-blue-70 fs-sm line-clamp-1"><span class="file-index"></span>: <b class="text-title-3">${file.name}</b></h6>`;

    // Vista previa
    const preview = document.createElement("div");
    preview.className = "card-body card-preview py-0";
    if (fileType === "application/pdf") {
      const icon = document.createElement("i");
      icon.className = "bi bi-file-earmark-pdf pdf-icon";
      preview.appendChild(icon);
    } else {
      const img = document.createElement("img");
      img.src = fileURL;
      img.className = "img-fluid";
      img.onload = () => URL.revokeObjectURL(fileURL);
      preview.appendChild(img);
    }

    // Botón de vista previa
    const viewBtn = document.createElement("button");
    viewBtn.type = "button";
    viewBtn.className = "btn view-btn";
    viewBtn.innerHTML = '<i class="bi bi-search"></i>';
    viewBtn.addEventListener("click", () =>
      showPreview(file, file.name, slide)
    );
    preview.appendChild(viewBtn);

    // Acciones del documento
    const actions = document.createElement("div");
    actions.className =
      "card-footer border-0 text-center d-flex justify-content-between";

    // Mensaje temporal "Subido con éxito"
    const successMessage = document.createElement("div");
    successMessage.className =
      "text-success p-1 fs-sm d-flex align-items-center justify-content-start";
    successMessage.innerHTML =
      '<i class="bi bi-check-circle me-1"></i> Subido con éxito.';

    actions.appendChild(successMessage);

    // Botón de eliminación
    const deleteBtn = document.createElement("button");
    deleteBtn.type = "button";
    deleteBtn.className = "btn delete-btn";
    deleteBtn.innerHTML = '<i class="fa-regular fa-trash-can"></i>';
    deleteBtn.addEventListener("click", () => {
      slide.remove();
      updateDocumentIndexes();
      initializeSwiper();
    });

    actions.appendChild(deleteBtn);
    card.appendChild(title);
    card.appendChild(preview);
    card.appendChild(actions);
    slide.appendChild(card);
    swiperWrapper.appendChild(slide);

    // Eliminar el mensaje después de 3 segundos
    setTimeout(() => {
      successMessage.remove();
      actions.classList.remove("justify-content-between");
      actions.classList.add("justify-content-center");
    }, 3000);

    updateDocumentIndexes();
  }

  function showPreview(file, fileName, slide) {
    // Obtener el índice del archivo en la lista actualizada
    const index = Array.from(slide.parentElement.children).reverse().indexOf(slide) + 1;
    previewModalTitle.innerHTML = `<h6 class="text-blue-70 fs-sm line-clamp-1">Archivo ${index}: <b class="text-title-3">${fileName}</b></h6>`;
    previewModalBody.innerHTML = "";

    if (file.type === "application/pdf") {
      const embed = document.createElement("embed");
      embed.src = URL.createObjectURL(file);
      embed.type = "application/pdf";
      embed.width = "100%";
      embed.height = "500px";
      previewModalBody.appendChild(embed);
    } else {
      const img = document.createElement("img");
      img.src = URL.createObjectURL(file);
      img.className = "img-fluid";
      previewModalBody.appendChild(img);
    }

    previewModal.show();
  }

  function updateDocumentIndexes() {
    const slides = Array.from(
      document.querySelectorAll(".swiper-slide")
    ).reverse(); // Orden descendente
    slides.forEach((slide, i) => {
      const index = i + 1; // Numeración descendente
      const title = slide.querySelector(".card-header h6");
      if (title) {
        const fileName = title.querySelector("b").textContent;
        title.innerHTML = `<h6 class="text-blue-70 fs-sm line-clamp-1">Archivo ${index}: <b class="text-title-3">${fileName}</b></h6>`;
      }
    });
  }

  initializeSwiper();
});
