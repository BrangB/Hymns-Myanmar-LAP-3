const fetchHymns = async (hymnId) => {
    try {
        const response = await fetch(`http://hymnsmyanmar.000.pe/backend/api.php?id=${hymnId}`);
        if (!response.ok) {
            throw new Error("Network response was not ok!");
        }
        const hymns = await response.json();
        console.log(hymns);

        const container = document.querySelector(".hymns");

        // Determine the maximum length of verses and choruses
        const maxLength = Math.max(hymns.verses.length, hymns.choruses.length);

        // for (let i = 0; i < maxLength; i++) {
        //     if (i < hymns.verses.length) {
        //         container.innerHTML += ` 
        //             <li>
        //                 ${hymns.verses[i].text}
        //             </li>
        //         `;
        //     }
        //     if (hymns.choruses !== "N/A" && i < hymns.choruses.length) {
        //         container.innerHTML += ` 
        //             <li class="chorus">
        //                 ${hymns.choruses[i].text}
        //             </li>
        //         `;
        //     }
        // }

        // Generate QR code URL with the hymnId
        generateQrCode(`https://hymnsmyanmar.vercel.app/pages/hymn.html?id=${hymnId}`);

    } catch (error) {
        console.error("Failed to fetch hymns:", error);
    }
};

console.log("hi")
fetchHymns(4)