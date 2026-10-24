package de.mythic.legenden;

import java.util.Map;
import java.util.Set;
import java.util.UUID;
import java.util.concurrent.ConcurrentHashMap;

import net.fabricmc.fabric.api.entity.event.v1.EntityElytraEvents;
import net.fabricmc.fabric.api.entity.event.v1.ServerLivingEntityEvents;
import net.fabricmc.fabric.api.event.lifecycle.v1.ServerTickEvents;
import net.fabricmc.fabric.api.networking.v1.ServerPlayConnectionEvents;
import net.minecraft.server.MinecraftServer;
import net.minecraft.server.level.ServerPlayer;
import net.minecraft.world.damagesource.DamageTypes;
import net.minecraft.world.entity.boss.enderdragon.EndCrystal;
import net.minecraft.world.entity.player.Player;

/**
 * PvP rules:
 *  - players take no damage from exploding end crystals and respawn anchors
 *  - hitting another player puts both into combat for COMBAT_SECONDS
 *  - logging out while in combat kills the player (items drop where they stood)
 *  - elytra gliding is blocked while in combat
 */
public final class PvpRules {
	public static final int COMBAT_SECONDS = 15;
	private static final Map<UUID, Long> COMBAT_UNTIL = new ConcurrentHashMap<>();
	private static final Set<UUID> ELYTRA_WARNED = ConcurrentHashMap.newKeySet();
	private static final Set<UUID> PUNISH_ON_JOIN = ConcurrentHashMap.newKeySet();
	private static int tick = 0;

	private PvpRules() {}

	public static void register() {
		// 1) no player damage from end crystals and respawn anchors
		ServerLivingEntityEvents.ALLOW_DAMAGE.register((entity, source, amount) -> {
			if (entity instanceof Player) {
				if (source.is(DamageTypes.BAD_RESPAWN_POINT)) return false;
				if (source.getDirectEntity() instanceof EndCrystal) return false;
			}
			return true;
		});

		// 2) combat tag on player-vs-player hits (melee, projectiles, legend abilities)
		ServerLivingEntityEvents.AFTER_DAMAGE.register((entity, source, baseDamage, damageTaken, blocked) -> {
			if (entity instanceof ServerPlayer victim && source.getEntity() instanceof ServerPlayer attacker && victim != attacker) {
				tag(victim);
				tag(attacker);
			}
		});
		ServerLivingEntityEvents.AFTER_DEATH.register((entity, source) -> {
			if (entity instanceof ServerPlayer p) {
				COMBAT_UNTIL.remove(p.getUUID());
				ELYTRA_WARNED.remove(p.getUUID());
			}
		});

		// combat logging = death
		ServerPlayConnectionEvents.DISCONNECT.register((handler, server) -> {
			ServerPlayer p = handler.getPlayer();
			if (p == null) return;
			UUID id = p.getUUID();
			if (inCombat(id) && !p.isSpectator() && !p.isCreative()) {
				String name = p.getScoreboardName();
				run(server, "kill " + p.getStringUUID());
				run(server, "tellraw @a [\"\",{\"text\":\"⚔ \",\"color\":\"red\"},{\"text\":\"" + name
						+ "\",\"color\":\"white\"},{\"text\":\" hat sich im Kampf ausgeloggt und ist gestorben.\",\"color\":\"gray\"}]");
				if (!p.isDeadOrDying()) PUNISH_ON_JOIN.add(id);
			}
			COMBAT_UNTIL.remove(id);
			ELYTRA_WARNED.remove(id);
		});
		ServerPlayConnectionEvents.JOIN.register((handler, sender, server) -> {
			ServerPlayer p = handler.getPlayer();
			if (p != null && PUNISH_ON_JOIN.remove(p.getUUID())) {
				run(server, "kill " + p.getStringUUID());
				run(server, "tellraw " + p.getStringUUID() + " {\"text\":\"⚔ Du hast dich im Kampf ausgeloggt.\",\"color\":\"red\"}");
			}
		});

		// countdown in the action bar, end-of-combat message
		ServerTickEvents.END_SERVER_TICK.register(server -> {
			if (++tick % 20 != 0) return;
			long now = System.currentTimeMillis();
			for (ServerPlayer p : server.getPlayerList().getPlayers()) {
				Long until = COMBAT_UNTIL.get(p.getUUID());
				if (until == null) continue;
				String who = p.getStringUUID();
				if (now >= until) {
					COMBAT_UNTIL.remove(p.getUUID());
					ELYTRA_WARNED.remove(p.getUUID());
					run(server, "title " + who + " actionbar {\"text\":\"✔ Du bist nicht mehr im Kampf\",\"color\":\"green\"}");
				} else {
					long s = (until - now + 999) / 1000;
					run(server, "title " + who + " actionbar [\"\",{\"text\":\"⚔ Im Kampf: \",\"color\":\"red\",\"bold\":true},{\"text\":\""
							+ s + " s\",\"color\":\"white\"},{\"text\":\"  ·  nicht ausloggen\",\"color\":\"gray\"}]");
				}
			}
		});

		// 3) no elytra while in combat (stops gliding immediately)
		EntityElytraEvents.ALLOW.register(entity -> {
			if (entity instanceof ServerPlayer p && inCombat(p.getUUID())) {
				if (ELYTRA_WARNED.add(p.getUUID()) && p.level().getServer() != null) {
					run(p.level().getServer(), "title " + p.getStringUUID() + " actionbar {\"text\":\"⚔ Elytra ist im Kampf gesperrt\",\"color\":\"red\"}");
				}
				return false;
			}
			return true;
		});
	}

	private static void tag(ServerPlayer p) {
		if (p.isCreative() || p.isSpectator()) return;
		boolean fresh = !inCombat(p.getUUID());
		COMBAT_UNTIL.put(p.getUUID(), System.currentTimeMillis() + COMBAT_SECONDS * 1000L);
		if (fresh && p.level().getServer() != null) {
			run(p.level().getServer(), "tellraw " + p.getStringUUID()
					+ " [\"\",{\"text\":\"⚔ Du bist im Kampf! \",\"color\":\"red\",\"bold\":true},{\"text\":\"Ausloggen = Tod. Elytra gesperrt.\",\"color\":\"gray\"}]");
		}
	}

	public static boolean inCombat(UUID id) {
		Long until = COMBAT_UNTIL.get(id);
		return until != null && System.currentTimeMillis() < until;
	}

	static void run(MinecraftServer server, String command) {
		server.getCommands().performPrefixedCommand(server.createCommandSourceStack().withSuppressedOutput(), command);
	}
}
