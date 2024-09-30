// script.js de l'API (openmeteo, pas besoin de clé API)
const apiUrl =
  "https://api.open-meteo.com/v1/forecast?latitude=43.2965&longitude=5.3698&daily=temperature_2m_max,temperature_2m_min,windspeed_10m_max&timezone=Europe/Paris";
fetch(apiUrl)
  .then((response) => {
    if (!response.ok) {
      throw new Error("Erreur réseau : " + response.statusText);
    }
    return response.json();
  })
  .then((data) => {
    console.log(data); // Vérifier la structure des données
    const weatherDiv = document.getElementById("weather");
    const dailyForecast = data.daily; // Contient les données sur plusieurs jours
    // Permet de faire un titre commun et pas dans chaque div crée
    let forecastHtml = "<p>Prévision météorologique</p>";
    // Parcourir chaque jour des prévisions
    for (let i = 0; i < dailyForecast.time.length; i++) {
      const date = dailyForecast.time[i]; // Date du jour
      const tempMax = dailyForecast.temperature_2m_max[i]; // Température max
      const tempMin = dailyForecast.temperature_2m_min[i]; // Température min
      const windSpeedMax = dailyForecast.windspeed_10m_max[i]; // Vitesse du vent max
      forecastHtml += `
        <div>
            <li><strong>${date}</strong></li>
            <li>Max : ${tempMax} °C </li>
            <li>min: ${tempMin} °C <br></li>
            <li>${windSpeedMax} km/h</li>
        </div>`;
    }
    weatherDiv.innerHTML = forecastHtml;
  })
  .catch((error) => {
    console.error("Erreur:", error);
    document.getElementById("weather").innerHTML = "Impossible de récupérer les données météo.";
  });
