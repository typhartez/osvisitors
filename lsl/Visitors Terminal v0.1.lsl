// Visitors Terminal v0.1 by djphil (CC-BY-NC-SA 4.0)

string  baseurl  = "http://domain.com/osvisitors/";
float   tempoat  = 30.0;
integer resetat  = 60;
integer textchat = FALSE;
string  welcome;
key     request;
list    visitor;
string  langues;
string  genders;
integer counter;
string  titlers;

default
{
    state_entry()
    {
        list details = llGetParcelDetails(llGetPos(), [PARCEL_DETAILS_OWNER]);
        if (llList2String(details ,0) != llGetOwner()) llDie();

        string script = llGetScriptName();
        titlers = "[" + script + "]";
        llSetObjectName(titlers);
        llSetText(titlers, <1.0, 1.0, 1.0>, 1.0);
        llSetTimerEvent(0.1);
    }

    touch_start(integer number)
    {
        llSetText(titlers, <1.0, 1.0, 1.0>, 1.0);
        llSetTimerEvent(0.1);
    }

    timer()
    {
        llSetTimerEvent(tempoat);

        string output = titlers;
        list current = llGetAgentList(AGENT_LIST_REGION, []);
        integer length = llGetListLength(current);

        integer i;

        for (i = 0; i < length; ++i)
        {
            key uuid = llList2Key(current, i);

            if (!osIsNpc(uuid))
            {
                if (~llListFindList(visitor, [uuid]))
                {
                    list infos = llGetObjectDetails(uuid, ([OBJECT_NAME, OBJECT_POS]));
                    output += "\n" +  llList2String(infos, 0) + " [" + llRound(llVecDist(llGetPos(), llList2String(infos, 1))) + "m]";
                }
    
                else if (llListFindList(visitor, [uuid]) == -1)
                {
                    visitor += [uuid];
    
                    list infos = llGetObjectDetails(uuid, ([OBJECT_NAME, OBJECT_POS]));
                    list details = llGetParcelDetails(llGetPos(), [PARCEL_DETAILS_NAME]);
    
                    output += "\n" +  llList2String(infos, 0) + " [" + llRound(llVecDist(llGetPos(), llList2String(infos, 1))) + "m]";
    
                    string name  = llList2String(infos, 0);
    
                    // llStringToBase64
                    request = llHTTPRequest(baseurl + "inc/visitors.php",
                        [HTTP_METHOD, "POST", HTTP_MIMETYPE, "application/x-www-form-urlencoded", HTTP_BODY_MAXLENGTH, 2048],
                            "terminal=visitors" + 
                            "&name="   + llEscapeURL(name) +
                            "&uuid="   + llEscapeURL((string)uuid) +
                            "&object=" + llEscapeURL(llGetObjectName()) +
                            "&region=" + llEscapeURL(llGetRegionName()) +
                            "&parcel=" + llEscapeURL(llList2String(details ,0)) +
                            "&host="   + llEscapeURL(llGetEnv("simulator_hostname")) +
                            "&grid="   + llEscapeURL(osGetGridName()) +
                            "&nick="   + llEscapeURL(osGetGridNick())
                    );

                    langues = llGetAgentLanguage(uuid);
                    genders = osGetGender(uuid);
                }

                else
                {
                    output += "\n" + "Something is wrong ...";
                }
            }

            else
            {
                list infos = llGetObjectDetails(uuid, ([OBJECT_NAME, OBJECT_POS]));
                output += "\n" +  llList2String(infos, 0) + " [" + llRound(llVecDist(llGetPos(), llList2String(infos, 1))) + "m]";
            }
        }

        llSetText(output, <1.0, 1.0, 1.0>, 1.0);
        ++counter;

        if (counter >= resetat)
        {
            counter = 0;
            visitor = [];
        }
    }

    http_response(key id, integer status, list data, string body)
    {
        if (id == request)
        {
            if (status != 200 || id == NULL_KEY)
            {
                llOwnerSay("[POST RECIEVED] " + status);
                return;
            }

            body = llStringTrim(body, STRING_TRIM);
    
            if (genders != "male" || genders != "female" || langues != "fr" || langues != "en")
            {
                welcome = "welcome_female_en";
            }
    
            else 
            {
                welcome = "welcome_" + genders + "_" + langues;
            }

            llTriggerSound(welcome, 1.0);    
            llSay(PUBLIC_CHANNEL, "\n" + body);
        }
    }

    on_rez(integer param) {llResetScript();}
    
    changed(integer change)
    {
        if (change & CHANGED_OWNER) {llResetScript();}
        if (change & CHANGED_REGION) {llResetScript();}
        if (change & CHANGED_REGION_RESTART) {llResetScript();}
        if (change & CHANGED_REGION_START) {llResetScript();}
    }
}