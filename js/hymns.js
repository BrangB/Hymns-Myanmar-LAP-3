// Function to extract query parameters from the URL
const getQueryParam = (param) => {
    const urlParams = new URLSearchParams(window.location.search);
    return urlParams.get(param);
};

const fetchHymns = async (hymnId) => {
    try {
        const response = await fetch(`https://hymnsmyanmar.000.pe/backend/api.php?id=${hymnId}`, {
            method: 'GET', // HTTP method
            headers: {
                'Content-Type': 'application/json', // Expecting JSON format in response
                'Accept': 'application/json', // Indicating that we accept JSON format
            },
        });

        if (!response.ok) {
            throw new Error("Network response was not ok!");
        }

        const hymns = await response.json();
        console.log(hymns);

        const container = document.querySelector(".hymns");

        // Determine the maximum length of verses and choruses
        const maxLength = Math.max(hymns.verses.length, hymns.choruses.length);

        for (let i = 0; i < maxLength; i++) {
            if (i < hymns.verses.length) {
                container.innerHTML += `<li>${hymns.verses[i].text}</li>`;
            }
            if (hymns.choruses !== "N/A" && i < hymns.choruses.length) {
                container.innerHTML += `<li class="chorus">${hymns.choruses[i].text}</li>`;
            }
        }

        // Generate QR code URL with the hymnId
        generateQrCode(`https://hymnsmyanmar.vercel.app/pages/hymn.html?id=${hymnId}`);

    } catch (error) {
        console.error("Failed to fetch hymns:", error);
    }
};


// Function to generate and display QR code
const generateQrCode = (data) => {
    const qrCodeUrl = `https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=${encodeURIComponent(data)}`;
    const qrCodeElement = document.querySelector(".qrCode");
    qrCodeElement.innerHTML = `<img src="${qrCodeUrl}" alt="QR Code" />`;
};

// Get the hymn ID from the URL and fetch the hymn details
document.addEventListener("DOMContentLoaded", () => {
    const hymnId = getQueryParam('id');
    if (hymnId) {
        fetchHymns(hymnId);
    } else {
        console.error("Hymn ID not found in the URL.");
    }
});
