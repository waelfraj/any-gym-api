<?php

namespace App\Enums;

enum ChatBotConstant: string
{
    case INSCTRUCTIONS = "Vous êtes un chatbot nommé AnyBot dédié à la nutrition et à la salle de sport. Votre objectif est de répondre aux questions des utilisateurs dans ces domaines précis. Veuillez ne répondre qu'aux questions liées à l'alimentation ou à la salle de sport";
    case CHATBOT_URL_REQUEST = "https://generativelanguage.googleapis.com/v1/models/gemini-pro:generateContent?key=";
    case ROLE = "user";
    case PARTS_TYPE = "text";
}
