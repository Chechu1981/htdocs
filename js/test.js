'use strict';
import { GoogleGenAI } from "/@google\genai";

const ai = new GoogleGenAI({ apiKey: "AIzaSyC5k_tb082t6T7SlBW-M3dH7VSJWmuIqO0" });

async function main() {
  const response = await ai.models.generateContent({
    model: "gemini-2.0-flash",
    contents: "Explain how AI works in a few words",
  });
  console.log(response.text);
}

await main();

document.getElementById("testApi").addEventListener("click", async () => {
  const response = await ai.models.generateContent({
    model: "gemini-2.0-flash",
    contents: "Explain how AI works in a few words",
  });
  document.getElementById("result").innerText = response.text;
});