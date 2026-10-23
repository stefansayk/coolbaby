package de.mythic.legenden;

import net.minecraft.network.RegistryFriendlyByteBuf;
import net.minecraft.network.codec.StreamCodec;
import net.minecraft.network.protocol.common.custom.CustomPacketPayload;

/** Sent from the client when the ability key is pressed. Sneaking is checked on the server. */
public record AbilityPayload() implements CustomPacketPayload {
	public static final AbilityPayload INSTANCE = new AbilityPayload();
	public static final CustomPacketPayload.Type<AbilityPayload> TYPE = new CustomPacketPayload.Type<>(MythicLegenden.id("ability"));
	public static final StreamCodec<RegistryFriendlyByteBuf, AbilityPayload> CODEC = StreamCodec.unit(INSTANCE);

	@Override
	public CustomPacketPayload.Type<? extends CustomPacketPayload> type() {
		return TYPE;
	}
}
