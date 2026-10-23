scoreboard objectives add mythic.forged dummy
scoreboard objectives add mythic.status trigger
scoreboard objectives add mythic.steps dummy
scoreboard objectives add mythic.tmp dummy
scoreboard objectives add mythic.const dummy
scoreboard players set #20 mythic.const 20
scoreboard objectives add mythic.cd.seelenernter.1 dummy
scoreboard objectives add mythic.cd.seelenernter.2 dummy
scoreboard objectives add mythic.cd.glutbart.1 dummy
scoreboard objectives add mythic.cd.glutbart.2 dummy
scoreboard objectives add mythic.cd.sternenspeer.1 dummy
scoreboard objectives add mythic.cd.sternenspeer.2 dummy
scoreboard objectives add mythic.cd.geisterbogen.1 dummy
scoreboard objectives add mythic.cd.geisterbogen.2 dummy
scoreboard objectives add mythic.cd.tiefseejaeger.1 dummy
scoreboard objectives add mythic.cd.tiefseejaeger.2 dummy
scoreboard objectives add mythic.cd.abyssdreizack.1 dummy
scoreboard objectives add mythic.cd.abyssdreizack.2 dummy
schedule function mythic:loop 5t replace
tellraw @a ["",{"text":"✦ Mythic Legenden ","color":"gold","bold":true},{"text":"geladen. Übersicht: ","color":"gray"},{"text":"/trigger mythic.status","color":"yellow"}]
