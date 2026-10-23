# Flammenatem: Feuerstoß nach vorn: 5 Schaden, Gegner brennen.
execute anchored eyes positioned ^ ^ ^2 run tag @e[type=!#mythic:not_target,tag=!mythic.caster,distance=..2] add mythic.t
execute anchored eyes positioned ^ ^ ^4.5 run tag @e[type=!#mythic:not_target,tag=!mythic.caster,distance=..2.5] add mythic.t
execute as @e[tag=mythic.t] run damage @s 5 minecraft:in_fire by @p[tag=mythic.caster]
execute as @e[tag=mythic.t,type=!minecraft:player] run data merge entity @s {Fire:120s}
execute anchored eyes positioned ^ ^ ^2 run particle minecraft:flame ~ ~-0.3 ~ 0.6 0.4 0.6 0.08 60
execute anchored eyes positioned ^ ^ ^4.5 run particle minecraft:flame ~ ~-0.3 ~ 1 0.6 1 0.06 80
playsound minecraft:item.firecharge.use player @a ~ ~ ~ 1 0.7
playsound minecraft:entity.blaze.shoot player @a ~ ~ ~ 1 0.8
tag @e[tag=mythic.t] remove mythic.t
