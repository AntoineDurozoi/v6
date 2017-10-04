<?php
// This file was auto-generated from sdk-root/src/data/directconnect/2012-10-25/api-2.json
return [ 'version' => '2.0', 'metadata' => [ 'apiVersion' => '2012-10-25', 'endpointPrefix' => 'directconnect', 'jsonVersion' => '1.1', 'protocol' => 'json', 'serviceFullName' => 'AWS Direct Connect', 'signatureVersion' => 'v4', 'targetPrefix' => 'OvertureService', 'uid' => 'directconnect-2012-10-25', ], 'operations' => [ 'AllocateConnectionOnInterconnect' => [ 'name' => 'AllocateConnectionOnInterconnect', 'http' => [ 'method' => 'POST', 'requestUri' => '/', ], 'input' => [ 'shape' => 'AllocateConnectionOnInterconnectRequest', ], 'output' => [ 'shape' => 'Connection', ], 'errors' => [ [ 'shape' => 'DirectConnectServerException', ], [ 'shape' => 'DirectConnectClientException', ], ], ], 'AllocateHostedConnection' => [ 'name' => 'AllocateHostedConnection', 'http' => [ 'method' => 'POST', 'requestUri' => '/', ], 'input' => [ 'shape' => 'AllocateHostedConnectionRequest', ], 'output' => [ 'shape' => 'Connection', ], 'errors' => [ [ 'shape' => 'DirectConnectServerException', ], [ 'shape' => 'DirectConnectClientException', ], ], ], 'AllocatePrivateVirtualInterface' => [ 'name' => 'AllocatePrivateVirtualInterface', 'http' => [ 'method' => 'POST', 'requestUri' => '/', ], 'input' => [ 'shape' => 'AllocatePrivateVirtualInterfaceRequest', ], 'output' => [ 'shape' => 'VirtualInterface', ], 'errors' => [ [ 'shape' => 'DirectConnectServerException', ], [ 'shape' => 'DirectConnectClientException', ], ], ], 'AllocatePublicVirtualInterface' => [ 'name' => 'AllocatePublicVirtualInterface', 'http' => [ 'method' => 'POST', 'requestUri' => '/', ], 'input' => [ 'shape' => 'AllocatePublicVirtualInterfaceRequest', ], 'output' => [ 'shape' => 'VirtualInterface', ], 'errors' => [ [ 'shape' => 'DirectConnectServerException', ], [ 'shape' => 'DirectConnectClientException', ], ], ], 'AssociateConnectionWithLag' => [ 'name' => 'AssociateConnectionWithLag', 'http' => [ 'method' => 'POST', 'requestUri' => '/', ], 'input' => [ 'shape' => 'AssociateConnectionWithLagRequest', ], 'output' => [ 'shape' => 'Connection', ], 'errors' => [ [ 'shape' => 'DirectConnectServerException', ], [ 'shape' => 'DirectConnectClientException', ], ], ], 'AssociateHostedConnection' => [ 'name' => 'AssociateHostedConnection', 'http' => [ 'method' => 'POST', 'requestUri' => '/', ], 'input' => [ 'shape' => 'AssociateHostedConnectionRequest', ], 'output' => [ 'shape' => 'Connection', ], 'errors' => [ [ 'shape' => 'DirectConnectServerException', ], [ 'shape' => 'DirectConnectClientException', ], ], ], 'AssociateVirtualInterface' => [ 'name' => 'AssociateVirtualInterface', 'http' => [ 'method' => 'POST', 'requestUri' => '/', ], 'input' => [ 'shape' => 'AssociateVirtualInterfaceRequest', ], 'output' => [ 'shape' => 'VirtualInterface', ], 'errors' => [ [ 'shape' => 'DirectConnectServerException', ], [ 'shape' => 'DirectConnectClientException', ], ], ], 'ConfirmConnection' => [ 'name' => 'ConfirmConnection', 'http' => [ 'method' => 'POST', 'requestUri' => '/', ], 'input' => [ 'shape' => 'ConfirmConnectionRequest', ], 'output' => [ 'shape' => 'ConfirmConnectionResponse', ], 'errors' => [ [ 'shape' => 'DirectConnectServerException', ], [ 'shape' => 'DirectConnectClientException', ], ], ], 'ConfirmPrivateVirtualInterface' => [ 'name' => 'ConfirmPrivateVirtualInterface', 'http' => [ 'method' => 'POST', 'requestUri' => '/', ], 'input' => [ 'shape' => 'ConfirmPrivateVirtualInterfaceRequest', ], 'output' => [ 'shape' => 'ConfirmPrivateVirtualInterfaceResponse', ], 'errors' => [ [ 'shape' => 'DirectConnectServerException', ], [ 'shape' => 'DirectConnectClientException', ], ], ], 'ConfirmPublicVirtualInterface' => [ 'name' => 'ConfirmPublicVirtualInterface', 'http' => [ 'method' => 'POST', 'requestUri' => '/', ], 'input' => [ 'shape' => 'ConfirmPublicVirtualInterfaceRequest', ], 'output' => [ 'shape' => 'ConfirmPublicVirtualInterfaceResponse', ], 'errors' => [ [ 'shape' => 'DirectConnectServerException', ], [ 'shape' => 'DirectConnectClientException', ], ], ], 'CreateBGPPeer' => [ 'name' => 'CreateBGPPeer', 'http' => [ 'method' => 'POST', 'requestUri' => '/', ], 'input' => [ 'shape' => 'CreateBGPPeerRequest', ], 'output' => [ 'shape' => 'CreateBGPPeerResponse', ], 'errors' => [ [ 'shape' => 'DirectConnectServerException', ], [ 'shape' => 'DirectConnectClientException', ], ], ], 'CreateConnection' => [ 'name' => 'CreateConnection', 'http' => [ 'method' => 'POST', 'requestUri' => '/', ], 'input' => [ 'shape' => 'CreateConnectionRequest', ], 'output' => [ 'shape' => 'Connection', ], 'errors' => [ [ 'shape' => 'DirectConnectServerException', ], [ 'shape' => 'DirectConnectClientException', ], ], ], 'CreateInterconnect' => [ 'name' => 'CreateInterconnect', 'http' => [ 'method' => 'POST', 'requestUri' => '/', ], 'input' => [ 'shape' => 'CreateInterconnectRequest', ], 'output' => [ 'shape' => 'Interconnect', ], 'errors' => [ [ 'shape' => 'DirectConnectServerException', ], [ 'shape' => 'DirectConnectClientException', ], ], ], 'CreateLag' => [ 'name' => 'CreateLag', 'http' => [ 'method' => 'POST', 'requestUri' => '/', ], 'input' => [ 'shape' => 'CreateLagRequest', ], 'output' => [ 'shape' => 'Lag', ], 'errors' => [ [ 'shape' => 'DirectConnectServerException', ], [ 'shape' => 'DirectConnectClientException', ], ], ], 'CreatePrivateVirtualInterface' => [ 'name' => 'CreatePrivateVirtualInterface', 'http' => [ 'method' => 'POST', 'requestUri' => '/', ], 'input' => [ 'shape' => 'CreatePrivateVirtualInterfaceRequest', ], 'output' => [ 'shape' => 'VirtualInterface', ], 'errors' => [ [ 'shape' => 'DirectConnectServerException', ], [ 'shape' => 'DirectConnectClientException', ], ], ], 'CreatePublicVirtualInterface' => [ 'name' => 'CreatePublicVirtualInterface', 'http' => [ 'method' => 'POST', 'requestUri' => '/', ], 'input' => [ 'shape' => 'CreatePublicVirtualInterfaceRequest', ], 'output' => [ 'shape' => 'VirtualInterface', ], 'errors' => [ [ 'shape' => 'DirectConnectServerException', ], [ 'shape' => 'DirectConnectClientException', ], ], ], 'DeleteBGPPeer' => [ 'name' => 'DeleteBGPPeer', 'http' => [ 'method' => 'POST', 'requestUri' => '/', ], 'input' => [ 'shape' => 'DeleteBGPPeerRequest', ], 'output' => [ 'shape' => 'DeleteBGPPeerResponse', ], 'errors' => [ [ 'shape' => 'DirectConnectServerException', ], [ 'shape' => 'DirectConnectClientException', ], ], ], 'DeleteConnection' => [ 'name' => 'DeleteConnection', 'http' => [ 'method' => 'POST', 'requestUri' => '/', ], 'input' => [ 'shape' => 'DeleteConnectionRequest', ], 'output' => [ 'shape' => 'Connection', ], 'errors' => [ [ 'shape' => 'DirectConnectServerException', ], [ 'shape' => 'DirectConnectClientException', ], ], ], 'DeleteInterconnect' => [ 'name' => 'DeleteInterconnect', 'http' => [ 'method' => 'POST', 'requestUri' => '/', ], 'input' => [ 'shape' => 'DeleteInterconnectRequest', ], 'output' => [ 'shape' => 'DeleteInterconnectResponse', ], 'errors' => [ [ 'shape' => 'DirectConnectServerException', ], [ 'shape' => 'DirectConnectClientException', ], ], ], 'DeleteLag' => [ 'name' => 'DeleteLag', 'http' => [ 'method' => 'POST', 'requestUri' => '/', ], 'input' => [ 'shape' => 'DeleteLagRequest', ], 'output' => [ 'shape' => 'Lag', ], 'errors' => [ [ 'shape' => 'DirectConnectServerException', ], [ 'shape' => 'DirectConnectClientException', ], ], ], 'DeleteVirtualInterface' => [ 'name' => 'DeleteVirtualInterface', 'http' => [ 'method' => 'POST', 'requestUri' => '/', ], 'input' => [ 'shape' => 'DeleteVirtualInterfaceRequest', ], 'output' => [ 'shape' => 'DeleteVirtualInterfaceResponse', ], 'errors' => [ [ 'shape' => 'DirectConnectServerException', ], [ 'shape' => 'DirectConnectClientException', ], ], ], 'DescribeConnectionLoa' => [ 'name' => 'DescribeConnectionLoa', 'http' => [ 'method' => 'POST', 'requestUri' => '/', ], 'input' => [ 'shape' => 'DescribeConnectionLoaRequest', ], 'output' => [ 'shape' => 'DescribeConnectionLoaResponse', ], 'errors' => [ [ 'shape' => 'DirectConnectServerException', ], [ 'shape' => 'DirectConnectClientException', ], ], ], 'DescribeConnections' => [ 'name' => 'DescribeConnections', 'http' => [ 'method' => 'POST', 'requestUri' => '/', ], 'input' => [ 'shape' => 'DescribeConnectionsRequest', ], 'output' => [ 'shape' => 'Connections', ], 'errors' => [ [ 'shape' => 'DirectConnectServerException', ], [ 'shape' => 'DirectConnectClientException', ], ], ], 'DescribeConnectionsOnInterconnect' => [ 'name' => 'DescribeConnectionsOnInterconnect', 'http' => [ 'method' => 'POST', 'requestUri' => '/', ], 'input' => [ 'shape' => 'DescribeConnectionsOnInterconnectRequest', ], 'output' => [ 'shape' => 'Connections', ], 'errors' => [ [ 'shape' => 'DirectConnectServerException', ], [ 'shape' => 'DirectConnectClientException', ], ], ], 'DescribeHostedConnections' => [ 'name' => 'DescribeHostedConnections', 'http' => [ 'method' => 'POST', 'requestUri' => '/', ], 'input' => [ 'shape' => 'DescribeHostedConnectionsRequest', ], 'output' => [ 'shape' => 'Connections', ], 'errors' => [ [ 'shape' => 'DirectConnectServerException', ], [ 'shape' => 'DirectConnectClientException', ], ], ], 'DescribeInterconnectLoa' => [ 'name' => 'DescribeInterconnectLoa', 'http' => [ 'method' => 'POST', 'requestUri' => '/', ], 'input' => [ 'shape' => 'DescribeInterconnectLoaRequest', ], 'output' => [ 'shape' => 'DescribeInterconnectLoaResponse', ], 'errors' => [ [ 'shape' => 'DirectConnectServerException', ], [ 'shape' => 'DirectConnectClientException', ], ], ], 'DescribeInterconnects' => [ 'name' => 'DescribeInterconnects', 'http' => [ 'method' => 'POST', 'requestUri' => '/', ], 'input' => [ 'shape' => 'DescribeInterconnectsRequest', ], 'output' => [ 'shape' => 'Interconnects', ], 'errors' => [ [ 'shape' => 'DirectConnectServerException', ], [ 'shape' => 'DirectConnectClientException', ], ], ], 'DescribeLags' => [ 'name' => 'DescribeLags', 'http' => [ 'method' => 'POST', 'requestUri' => '/', ], 'input' => [ 'shape' => 'DescribeLagsRequest', ], 'output' => [ 'shape' => 'Lags', ], 'errors' => [ [ 'shape' => 'DirectConnectServerException', ], [ 'shape' => 'DirectConnectClientException', ], ], ], 'DescribeLoa' => [ 'name' => 'DescribeLoa', 'http' => [ 'method' => 'POST', 'requestUri' => '/', ], 'input' => [ 'shape' => 'DescribeLoaRequest', ], 'output' => [ 'shape' => 'Loa', ], 'errors' => [ [ 'shape' => 'DirectConnectServerException', ], [ 'shape' => 'DirectConnectClientException', ], ], ], 'DescribeLocations' => [ 'name' => 'DescribeLocations', 'http' => [ 'method' => 'POST', 'requestUri' => '/', ], 'output' => [ 'shape' => 'Locations', ], 'errors' => [ [ 'shape' => 'DirectConnectServerException', ], [ 'shape' => 'DirectConnectClientException', ], ], ], 'DescribeTags' => [ 'name' => 'DescribeTags', 'http' => [ 'method' => 'POST', 'requestUri' => '/', ], 'input' => [ 'shape' => 'DescribeTagsRequest', ], 'output' => [ 'shape' => 'DescribeTagsResponse', ], 'errors' => [ [ 'shape' => 'DirectConnectServerException', ], [ 'shape' => 'DirectConnectClientException', ], ], ], 'DescribeVirtualGateways' => [ 'name' => 'DescribeVirtualGateways', 'http' => [ 'method' => 'POST', 'requestUri' => '/', ], 'output' => [ 'shape' => 'VirtualGateways', ], 'errors' => [ [ 'shape' => 'DirectConnectServerException', ], [ 'shape' => 'DirectConnectClientException', ], ], ], 'DescribeVirtualInterfaces' => [ 'name' => 'DescribeVirtualInterfaces', 'http' => [ 'method' => 'POST', 'requestUri' => '/', ], 'input' => [ 'shape' => 'DescribeVirtualInterfacesRequest', ], 'output' => [ 'shape' => 'VirtualInterfaces', ], 'errors' => [ [ 'shape' => 'DirectConnectServerException', ], [ 'shape' => 'DirectConnectClientException', ], ], ], 'DisassociateConnectionFromLag' => [ 'name' => 'DisassociateConnectionFromLag', 'http' => [ 'method' => 'POST', 'requestUri' => '/', ], 'input' => [ 'shape' => 'DisassociateConnectionFromLagRequest', ], 'output' => [ 'shape' => 'Connection', ], 'errors' => [ [ 'shape' => 'DirectConnectServerException', ], [ 'shape' => 'DirectConnectClientException', ], ], ], 'TagResource' => [ 'name' => 'TagResource', 'http' => [ 'method' => 'POST', 'requestUri' => '/', ], 'input' => [ 'shape' => 'TagResourceRequest', ], 'output' => [ 'shape' => 'TagResourceResponse', ], 'errors' => [ [ 'shape' => 'DuplicateTagKeysException', ], [ 'shape' => 'TooManyTagsException', ], [ 'shape' => 'DirectConnectServerException', ], [ 'shape' => 'DirectConnectClientException', ], ], ], 'UntagResource' => [ 'name' => 'UntagResource', 'http' => [ 'method' => 'POST', 'requestUri' => '/', ], 'input' => [ 'shape' => 'UntagResourceRequest', ], 'output' => [ 'shape' => 'UntagResourceResponse', ], 'errors' => [ [ 'shape' => 'DirectConnectServerException', ], [ 'shape' => 'DirectConnectClientException', ], ], ], 'UpdateLag' => [ 'name' => 'UpdateLag', 'http' => [ 'method' => 'POST', 'requestUri' => '/', ], 'input' => [ 'shape' => 'UpdateLagRequest', ], 'output' => [ 'shape' => 'Lag', ], 'errors' => [ [ 'shape' => 'DirectConnectServerException', ], [ 'shape' => 'DirectConnectClientException', ], ], ], ], 'shapes' => [ 'ASN' => [ 'type' => 'integer', ], 'AddressFamily' => [ 'type' => 'string', 'enum' => [ 'ipv4', 'ipv6', ], ], 'AllocateConnectionOnInterconnectRequest' => [ 'type' => 'structure', 'required' => [ 'bandwidth', 'connectionName', 'ownerAccount', 'interconnectId', 'vlan', ], 'members' => [ 'bandwidth' => [ 'shape' => 'Bandwidth', ], 'connectionName' => [ 'shape' => 'ConnectionName', ], 'ownerAccount' => [ 'shape' => 'OwnerAccount', ], 'interconnectId' => [ 'shape' => 'InterconnectId', ], 'vlan' => [ 'shape' => 'VLAN', ], ], ], 'AllocateHostedConnectionRequest' => [ 'type' => 'structure', 'required' => [ 'connectionId', 'ownerAccount', 'bandwidth', 'connectionName', 'vlan', ], 'members' => [ 'connectionId' => [ 'shape' => 'ConnectionId', ], 'ownerAccount' => [ 'shape' => 'OwnerAccount', ], 'bandwidth' => [ 'shape' => 'Bandwidth', ], 'connectionName' => [ 'shape' => 'ConnectionName', ], 'vlan' => [ 'shape' => 'VLAN', ], ], ], 'AllocatePrivateVirtualInterfaceRequest' => [ 'type' => 'structure', 'required' => [ 'connectionId', 'ownerAccount', 'newPrivateVirtualInterfaceAllocation', ], 'members' => [ 'connectionId' => [ 'shape' => 'ConnectionId', ], 'ownerAccount' => [ 'shape' => 'OwnerAccount', ], 'newPrivateVirtualInterfaceAllocation' => [ 'shape' => 'NewPrivateVirtualInterfaceAllocation', ], ], ], 'AllocatePublicVirtualInterfaceRequest' => [ 'type' => 'structure', 'required' => [ 'connectionId', 'ownerAccount', 'newPublicVirtualInterfaceAllocation', ], 'members' => [ 'connectionId' => [ 'shape' => 'ConnectionId', ], 'ownerAccount' => [ 'shape' => 'OwnerAccount', ], 'newPublicVirtualInterfaceAllocation' => [ 'shape' => 'NewPublicVirtualInterfaceAllocation', ], ], ], 'AmazonAddress' => [ 'type' => 'string', ], 'AssociateConnectionWithLagRequest' => [ 'type' => 'structure', 'required' => [ 'connectionId', 'lagId', ], 'members' => [ 'connectionId' => [ 'shape' => 'ConnectionId', ], 'lagId' => [ 'shape' => 'LagId', ], ], ], 'AssociateHostedConnectionRequest' => [ 'type' => 'structure', 'required' => [ 'connectionId', 'parentConnectionId', ], 'members' => [ 'connectionId' => [ 'shape' => 'ConnectionId', ], 'parentConnectionId' => [ 'shape' => 'ConnectionId', ], ], ], 'AssociateVirtualInterfaceRequest' => [ 'type' => 'structure', 'required' => [ 'virtualInterfaceId', 'connectionId', ], 'members' => [ 'virtualInterfaceId' => [ 'shape' => 'VirtualInterfaceId', ], 'connectionId' => [ 'shape' => 'ConnectionId', ], ], ], 'AwsDevice' => [ 'type' => 'string', ], 'BGPAuthKey' => [ 'type' => 'string', ], 'BGPPeer' => [ 'type' => 'structure', 'members' => [ 'asn' => [ 'shape' => 'ASN', ], 'authKey' => [ 'shape' => 'BGPAuthKey', ], 'addressFamily' => [ 'shape' => 'AddressFamily', ], 'amazonAddress' => [ 'shape' => 'AmazonAddress', ], 'customerAddress' => [ 'shape' => 'CustomerAddress', ], 'bgpPeerState' => [ 'shape' => 'BGPPeerState', ], 'bgpStatus' => [ 'shape' => 'BGPStatus', ], ], ], 'BGPPeerList' => [ 'type' => 'list', 'member' => [ 'shape' => 'BGPPeer', ], ], 'BGPPeerState' => [ 'type' => 'string', 'enum' => [ 'verifying', 'pending', 'available', 'deleting', 'deleted', ], ], 'BGPStatus' => [ 'type' => 'string', 'enum' => [ 'up', 'down', ], ], 'Bandwidth' => [ 'type' => 'string', ], 'BooleanFlag' => [ 'type' => 'boolean', ], 'CIDR' => [ 'type' => 'string', ], 'ConfirmConnectionRequest' => [ 'type' => 'structure', 'required' => [ 'connectionId', ], 'members' => [ 'connectionId' => [ 'shape' => 'ConnectionId', ], ], ], 'ConfirmConnectionResponse' => [ 'type' => 'structure', 'members' => [ 'connectionState' => [ 'shape' => 'ConnectionState', ], ], ], 'ConfirmPrivateVirtualInterfaceRequest' => [ 'type' => 'structure', 'required' => [ 'virtualInterfaceId', 'virtualGatewayId', ], 'members' => [ 'virtualInterfaceId' => [ 'shape' => 'VirtualInterfaceId', ], 'virtualGatewayId' => [ 'shape' => 'VirtualGatewayId', ], ], ], 'ConfirmPrivateVirtualInterfaceResponse' => [ 'type' => 'structure', 'members' => [ 'virtualInterfaceState' => [ 'shape' => 'VirtualInterfaceState', ], ], ], 'ConfirmPublicVirtualInterfaceRequest' => [ 'type' => 'structure', 'required' => [ 'virtualInterfaceId', ], 'members' => [ 'virtualInterfaceId' => [ 'shape' => 'VirtualInterfaceId', ], ], ], 'ConfirmPublicVirtualInterfaceResponse' => [ 'type' => 'structure', 'members' => [ 'virtualInterfaceState' => [ 'shape' => 'VirtualInterfaceState', ], ], ], 'Connection' => [ 'type' => 'structure', 'members' => [ 'ownerAccount' => [ 'shape' => 'OwnerAccount', ], 'connectionId' => [ 'shape' => 'ConnectionId', ], 'connectionName' => [ 'shape' => 'ConnectionName', ], 'connectionState' => [ 'shape' => 'ConnectionState', ], 'region' => [ 'shape' => 'Region', ], 'location' => [ 'shape' => 'LocationCode', ], 'bandwidth' => [ 'shape' => 'Bandwidth', ], 'vlan' => [ 'shape' => 'VLAN', ], 'partnerName' => [ 'shape' => 'PartnerName', ], 'loaIssueTime' => [ 'shape' => 'LoaIssueTime', ], 'lagId' => [ 'shape' => 'LagId', ], 'awsDevice' => [ 'shape' => 'AwsDevice', ], ], ], 'ConnectionId' => [ 'type' => 'string', ], 'ConnectionList' => [ 'type' => 'list', 'member' => [ 'shape' => 'Connection', ], ], 'ConnectionName' => [ 'type' => 'string', ], 'ConnectionState' => [ 'type' => 'string', 'enum' => [ 'ordering', 'requested', 'pending', 'available', 'down', 'deleting', 'deleted', 'rejected', ], ], 'Connections' => [ 'type' => 'structure', 'members' => [ 'connections' => [ 'shape' => 'ConnectionList', ], ], ], 'Count' => [ 'type' => 'integer', ], 'CreateBGPPeerRequest' => [ 'type' => 'structure', 'members' => [ 'virtualInterfaceId' => [ 'shape' => 'VirtualInterfaceId', ], 'newBGPPeer' => [ 'shape' => 'NewBGPPeer', ], ], ], 'CreateBGPPeerResponse' => [ 'type' => 'structure', 'members' => [ 'virtualInterface' => [ 'shape' => 'VirtualInterface', ], ], ], 'CreateConnectionRequest' => [ 'type' => 'structure', 'required' => [ 'location', 'bandwidth', 'connectionName', ], 'members' => [ 'location' => [ 'shape' => 'LocationCode', ], 'bandwidth' => [ 'shape' => 'Bandwidth', ], 'connectionName' => [ 'shape' => 'ConnectionName', ], 'lagId' => [ 'shape' => 'LagId', ], ], ], 'CreateInterconnectRequest' => [ 'type' => 'structure', 'required' => [ 'interconnectName', 'bandwidth', 'location', ], 'members' => [ 'interconnectName' => [ 'shape' => 'InterconnectName', ], 'bandwidth' => [ 'shape' => 'Bandwidth', ], 'location' => [ 'shape' => 'LocationCode', ], 'lagId' => [ 'shape' => 'LagId', ], ], ], 'CreateLagRequest' => [ 'type' => 'structure', 'required' => [ 'numberOfConnections', 'location', 'connectionsBandwidth', 'lagName', ], 'members' => [ 'numberOfConnections' => [ 'shape' => 'Count', ], 'location' => [ 'shape' => 'LocationCode', ], 'connectionsBandwidth' => [ 'shape' => 'Bandwidth', ], 'lagName' => [ 'shape' => 'LagName', ], 'connectionId' => [ 'shape' => 'ConnectionId', ], ], ], 'CreatePrivateVirtualInterfaceRequest' => [ 'type' => 'structure', 'required' => [ 'connectionId', 'newPrivateVirtualInterface', ], 'members' => [ 'connectionId' => [ 'shape' => 'ConnectionId', ], 'newPrivateVirtualInterface' => [ 'shape' => 'NewPrivateVirtualInterface', ], ], ], 'CreatePublicVirtualInterfaceRequest' => [ 'type' => 'structure', 'required' => [ 'connectionId', 'newPublicVirtualInterface', ], 'members' => [ 'connectionId' => [ 'shape' => 'ConnectionId', ], 'newPublicVirtualInterface' => [ 'shape' => 'NewPublicVirtualInterface', ], ], ], 'CustomerAddress' => [ 'type' => 'string', ], 'DeleteBGPPeerRequest' => [ 'type' => 'structure', 'members' => [ 'virtualInterfaceId' => [ 'shape' => 'VirtualInterfaceId', ], 'asn' => [ 'shape' => 'ASN', ], 'customerAddress' => [ 'shape' => 'CustomerAddress', ], ], ], 'DeleteBGPPeerResponse' => [ 'type' => 'structure', 'members' => [ 'virtualInterface' => [ 'shape' => 'VirtualInterface', ], ], ], 'DeleteConnectionRequest' => [ 'type' => 'structure', 'required' => [ 'connectionId', ], 'members' => [ 'connectionId' => [ 'shape' => 'ConnectionId', ], ], ], 'DeleteInterconnectRequest' => [ 'type' => 'structure', 'required' => [ 'interconnectId', ], 'members' => [ 'interconnectId' => [ 'shape' => 'InterconnectId', ], ], ], 'DeleteInterconnectResponse' => [ 'type' => 'structure', 'members' => [ 'interconnectState' => [ 'shape' => 'InterconnectState', ], ], ], 'DeleteLagRequest' => [ 'type' => 'structure', 'required' => [ 'lagId', ], 'members' => [ 'lagId' => [ 'shape' => 'LagId', ], ], ], 'DeleteVirtualInterfaceRequest' => [ 'type' => 'structure', 'required' => [ 'virtualInterfaceId', ], 'members' => [ 'virtualInterfaceId' => [ 'shape' => 'VirtualInterfaceId', ], ], ], 'DeleteVirtualInterfaceResponse' => [ 'type' => 'structure', 'members' => [ 'virtualInterfaceState' => [ 'shape' => 'VirtualInterfaceState', ], ], ], 'DescribeConnectionLoaRequest' => [ 'type' => 'structure', 'required' => [ 'connectionId', ], 'members' => [ 'connectionId' => [ 'shape' => 'ConnectionId', ], 'providerName' => [ 'shape' => 'ProviderName', ], 'loaContentType' => [ 'shape' => 'LoaContentType', ], ], ], 'DescribeConnectionLoaResponse' => [ 'type' => 'structure', 'members' => [ 'loa' => [ 'shape' => 'Loa', ], ], ], 'DescribeConnectionsOnInterconnectRequest' => [ 'type' => 'structure', 'required' => [ 'interconnectId', ], 'members' => [ 'interconnectId' => [ 'shape' => 'InterconnectId', ], ], ], 'DescribeConnectionsRequest' => [ 'type' => 'structure', 'members' => [ 'connectionId' => [ 'shape' => 'ConnectionId', ], ], ], 'DescribeHostedConnectionsRequest' => [ 'type' => 'structure', 'required' => [ 'connectionId', ], 'members' => [ 'connectionId' => [ 'shape' => 'ConnectionId', ], ], ], 'DescribeInterconnectLoaRequest' => [ 'type' => 'structure', 'required' => [ 'interconnectId', ], 'members' => [ 'interconnectId' => [ 'shape' => 'InterconnectId', ], 'providerName' => [ 'shape' => 'ProviderName', ], 'loaContentType' => [ 'shape' => 'LoaContentType', ], ], ], 'DescribeInterconnectLoaResponse' => [ 'type' => 'structure', 'members' => [ 'loa' => [ 'shape' => 'Loa', ], ], ], 'DescribeInterconnectsRequest' => [ 'type' => 'structure', 'members' => [ 'interconnectId' => [ 'shape' => 'InterconnectId', ], ], ], 'DescribeLagsRequest' => [ 'type' => 'structure', 'members' => [ 'lagId' => [ 'shape' => 'LagId', ], ], ], 'DescribeLoaRequest' => [ 'type' => 'structure', 'required' => [ 'connectionId', ], 'members' => [ 'connectionId' => [ 'shape' => 'ConnectionId', ], 'providerName' => [ 'shape' => 'ProviderName', ], 'loaContentType' => [ 'shape' => 'LoaContentType', ], ], ], 'DescribeTagsRequest' => [ 'type' => 'structure', 'required' => [ 'resourceArns', ], 'members' => [ 'resourceArns' => [ 'shape' => 'ResourceArnList', ], ], ], 'DescribeTagsResponse' => [ 'type' => 'structure', 'members' => [ 'resourceTags' => [ 'shape' => 'ResourceTagList', ], ], ], 'DescribeVirtualInterfacesRequest' => [ 'type' => 'structure', 'members' => [ 'connectionId' => [ 'shape' => 'ConnectionId', ], 'virtualInterfaceId' => [ 'shape' => 'VirtualInterfaceId', ], ], ], 'DirectConnectClientException' => [ 'type' => 'structure', 'members' => [ 'message' => [ 'shape' => 'ErrorMessage', ], ], 'exception' => true, ], 'DirectConnectServerException' => [ 'type' => 'structure', 'members' => [ 'message' => [ 'shape' => 'ErrorMessage', ], ], 'exception' => true, ], 'DisassociateConnectionFromLagRequest' => [ 'type' => 'structure', 'required' => [ 'connectionId', 'lagId', ], 'members' => [ 'connectionId' => [ 'shape' => 'ConnectionId', ], 'lagId' => [ 'shape' => 'LagId', ], ], ], 'DuplicateTagKeysException' => [ 'type' => 'structure', 'members' => [], 'exception' => true, ], 'ErrorMessage' => [ 'type' => 'string', ], 'Interconnect' => [ 'type' => 'structure', 'members' => [ 'interconnectId' => [ 'shape' => 'InterconnectId', ], 'interconnectName' => [ 'shape' => 'InterconnectName', ], 'interconnectState' => [ 'shape' => 'InterconnectState', ], 'region' => [ 'shape' => 'Region', ], 'location' => [ 'shape' => 'LocationCode', ], 'bandwidth' => [ 'shape' => 'Bandwidth', ], 'loaIssueTime' => [ 'shape' => 'LoaIssueTime', ], 'lagId' => [ 'shape' => 'LagId', ], 'awsDevice' => [ 'shape' => 'AwsDevice', ], ], ], 'InterconnectId' => [ 'type' => 'string', ], 'InterconnectList' => [ 'type' => 'list', 'member' => [ 'shape' => 'Interconnect', ], ], 'InterconnectName' => [ 'type' => 'string', ], 'InterconnectState' => [ 'type' => 'string', 'enum' => [ 'requested', 'pending', 'available', 'down', 'deleting', 'deleted', ], ], 'Interconnects' => [ 'type' => 'structure', 'members' => [ 'interconnects' => [ 'shape' => 'InterconnectList', ], ], ], 'Lag' => [ 'type' => 'structure', 'members' => [ 'connectionsBandwidth' => [ 'shape' => 'Bandwidth', ], 'numberOfConnections' => [ 'shape' => 'Count', ], 'lagId' => [ 'shape' => 'LagId', ], 'ownerAccount' => [ 'shape' => 'OwnerAccount', ], 'lagName' => [ 'shape' => 'LagName', ], 'lagState' => [ 'shape' => 'LagState', ], 'location' => [ 'shape' => 'LocationCode', ], 'region' => [ 'shape' => 'Region', ], 'minimumLinks' => [ 'shape' => 'Count', ], 'awsDevice' => [ 'shape' => 'AwsDevice', ], 'connections' => [ 'shape' => 'ConnectionList', ], 'allowsHostedConnections' => [ 'shape' => 'BooleanFlag', ], ], ], 'LagId' => [ 'type' => 'string', ], 'LagList' => [ 'type' => 'list', 'member' => [ 'shape' => 'Lag', ], ], 'LagName' => [ 'type' => 'string', ], 'LagState' => [ 'type' => 'string', 'enum' => [ 'requested', 'pending', 'available', 'down', 'deleting', 'deleted', ], ], 'Lags' => [ 'type' => 'structure', 'members' => [ 'lags' => [ 'shape' => 'LagList', ], ], ], 'Loa' => [ 'type' => 'structure', 'members' => [ 'loaContent' => [ 'shape' => 'LoaContent', ], 'loaContentType' => [ 'shape' => 'LoaContentType', ], ], ], 'LoaContent' => [ 'type' => 'blob', ], 'LoaContentType' => [ 'type' => 'string', 'enum' => [ 'application/pdf', ], ], 'LoaIssueTime' => [ 'type' => 'timestamp', ], 'Location' => [ 'type' => 'structure', 'members' => [ 'locationCode' => [ 'shape' => 'LocationCode', ], 'locationName' => [ 'shape' => 'LocationName', ], ], ], 'LocationCode' => [ 'type' => 'string', ], 'LocationList' => [ 'type' => 'list', 'member' => [ 'shape' => 'Location', ], ], 'LocationName' => [ 'type' => 'string', ], 'Locations' => [ 'type' => 'structure', 'members' => [ 'locations' => [ 'shape' => 'LocationList', ], ], ], 'NewBGPPeer' => [ 'type' => 'structure', 'members' => [ 'asn' => [ 'shape' => 'ASN', ], 'authKey' => [ 'shape' => 'BGPAuthKey', ], 'addressFamily' => [ 'shape' => 'AddressFamily', ], 'amazonAddress' => [ 'shape' => 'AmazonAddress', ], 'customerAddress' => [ 'shape' => 'CustomerAddress', ], ], ], 'NewPrivateVirtualInterface' => [ 'type' => 'structure', 'required' => [ 'virtualInterfaceName', 'vlan', 'asn', 'virtualGatewayId', ], 'members' => [ 'virtualInterfaceName' => [ 'shape' => 'VirtualInterfaceName', ], 'vlan' => [ 'shape' => 'VLAN', ], 'asn' => [ 'shape' => 'ASN', ], 'authKey' => [ 'shape' => 'BGPAuthKey', ], 'amazonAddress' => [ 'shape' => 'AmazonAddress', ], 'customerAddress' => [ 'shape' => 'CustomerAddress', ], 'addressFamily' => [ 'shape' => 'AddressFamily', ], 'virtualGatewayId' => [ 'shape' => 'VirtualGatewayId', ], ], ], 'NewPrivateVirtualInterfaceAllocation' => [ 'type' => 'structure', 'required' => [ 'virtualInterfaceName', 'vlan', 'asn', ], 'members' => [ 'virtualInterfaceName' => [ 'shape' => 'VirtualInterfaceName', ], 'vlan' => [ 'shape' => 'VLAN', ], 'asn' => [ 'shape' => 'ASN', ], 'authKey' => [ 'shape' => 'BGPAuthKey', ], 'amazonAddress' => [ 'shape' => 'AmazonAddress', ], 'addressFamily' => [ 'shape' => 'AddressFamily', ], 'customerAddress' => [ 'shape' => 'CustomerAddress', ], ], ], 'NewPublicVirtualInterface' => [ 'type' => 'structure', 'required' => [ 'virtualInterfaceName', 'vlan', 'asn', ], 'members' => [ 'virtualInterfaceName' => [ 'shape' => 'VirtualInterfaceName', ], 'vlan' => [ 'shape' => 'VLAN', ], 'asn' => [ 'shape' => 'ASN', ], 'authKey' => [ 'shape' => 'BGPAuthKey', ], 'amazonAddress' => [ 'shape' => 'AmazonAddress', ], 'customerAddress' => [ 'shape' => 'CustomerAddress', ], 'addressFamily' => [ 'shape' => 'AddressFamily', ], 'routeFilterPrefixes' => [ 'shape' => 'RouteFilterPrefixList', ], ], ], 'NewPublicVirtualInterfaceAllocation' => [ 'type' => 'structure', 'required' => [ 'virtualInterfaceName', 'vlan', 'asn', ], 'members' => [ 'virtualInterfaceName' => [ 'shape' => 'VirtualInterfaceName', ], 'vlan' => [ 'shape' => 'VLAN', ], 'asn' => [ 'shape' => 'ASN', ], 'authKey' => [ 'shape' => 'BGPAuthKey', ], 'amazonAddress' => [ 'shape' => 'AmazonAddress', ], 'customerAddress' => [ 'shape' => 'CustomerAddress', ], 'addressFamily' => [ 'shape' => 'AddressFamily', ], 'routeFilterPrefixes' => [ 'shape' => 'RouteFilterPrefixList', ], ], ], 'OwnerAccount' => [ 'type' => 'string', ], 'PartnerName' => [ 'type' => 'string', ], 'ProviderName' => [ 'type' => 'string', ], 'Region' => [ 'type' => 'string', ], 'ResourceArn' => [ 'type' => 'string', ], 'ResourceArnList' => [ 'type' => 'list', 'member' => [ 'shape' => 'ResourceArn', ], ], 'ResourceTag' => [ 'type' => 'structure', 'members' => [ 'resourceArn' => [ 'shape' => 'ResourceArn', ], 'tags' => [ 'shape' => 'TagList', ], ], ], 'ResourceTagList' => [ 'type' => 'list', 'member' => [ 'shape' => 'ResourceTag', ], ], 'RouteFilterPrefix' => [ 'type' => 'structure', 'members' => [ 'cidr' => [ 'shape' => 'CIDR', ], ], ], 'RouteFilterPrefixList' => [ 'type' => 'list', 'member' => [ 'shape' => 'RouteFilterPrefix', ], ], 'RouterConfig' => [ 'type' => 'string', ], 'Tag' => [ 'type' => 'structure', 'required' => [ 'key', ], 'members' => [ 'key' => [ 'shape' => 'TagKey', ], 'value' => [ 'shape' => 'TagValue', ], ], ], 'TagKey' => [ 'type' => 'string', 'max' => 128, 'min' => 1, 'pattern' => '^([\\p{L}\\p{Z}\\p{N}_.:/=+\\-@]*)$', ], 'TagKeyList' => [ 'type' => 'list', 'member' => [ 'shape' => 'TagKey', ], ], 'TagList' => [ 'type' => 'list', 'member' => [ 'shape' => 'Tag', ], 'min' => 1, ], 'TagResourceRequest' => [ 'type' => 'structure', 'required' => [ 'resourceArn', 'tags', ], 'members' => [ 'resourceArn' => [ 'shape' => 'ResourceArn', ], 'tags' => [ 'shape' => 'TagList', ], ], ], 'TagResourceResponse' => [ 'type' => 'structure', 'members' => [], ], 'TagValue' => [ 'type' => 'string', 'max' => 256, 'min' => 0, 'pattern' => '^([\\p{L}\\p{Z}\\p{N}_.:/=+\\-@]*)$', ], 'TooManyTagsException' => [ 'type' => 'structure', 'members' => [], 'exception' => true, ], 'UntagResourceRequest' => [ 'type' => 'structure', 'required' => [ 'resourceArn', 'tagKeys', ], 'members' => [ 'resourceArn' => [ 'shape' => 'ResourceArn', ], 'tagKeys' => [ 'shape' => 'TagKeyList', ], ], ], 'UntagResourceResponse' => [ 'type' => 'structure', 'members' => [], ], 'UpdateLagRequest' => [ 'type' => 'structure', 'required' => [ 'lagId', ], 'members' => [ 'lagId' => [ 'shape' => 'LagId', ], 'lagName' => [ 'shape' => 'LagName', ], 'minimumLinks' => [ 'shape' => 'Count', ], ], ], 'VLAN' => [ 'type' => 'integer', ], 'VirtualGateway' => [ 'type' => 'structure', 'members' => [ 'virtualGatewayId' => [ 'shape' => 'VirtualGatewayId', ], 'virtualGatewayState' => [ 'shape' => 'VirtualGatewayState', ], ], ], 'VirtualGatewayId' => [ 'type' => 'string', ], 'VirtualGatewayList' => [ 'type' => 'list', 'member' => [ 'shape' => 'VirtualGateway', ], ], 'VirtualGatewayState' => [ 'type' => 'string', ], 'VirtualGateways' => [ 'type' => 'structure', 'members' => [ 'virtualGateways' => [ 'shape' => 'VirtualGatewayList', ], ], ], 'VirtualInterface' => [ 'type' => 'structure', 'members' => [ 'ownerAccount' => [ 'shape' => 'OwnerAccount', ], 'virtualInterfaceId' => [ 'shape' => 'VirtualInterfaceId', ], 'location' => [ 'shape' => 'LocationCode', ], 'connectionId' => [ 'shape' => 'ConnectionId', ], 'virtualInterfaceType' => [ 'shape' => 'VirtualInterfaceType', ], 'virtualInterfaceName' => [ 'shape' => 'VirtualInterfaceName', ], 'vlan' => [ 'shape' => 'VLAN', ], 'asn' => [ 'shape' => 'ASN', ], 'authKey' => [ 'shape' => 'BGPAuthKey', ], 'amazonAddress' => [ 'shape' => 'AmazonAddress', ], 'customerAddress' => [ 'shape' => 'CustomerAddress', ], 'addressFamily' => [ 'shape' => 'AddressFamily', ], 'virtualInterfaceState' => [ 'shape' => 'VirtualInterfaceState', ], 'customerRouterConfig' => [ 'shape' => 'RouterConfig', ], 'virtualGatewayId' => [ 'shape' => 'VirtualGatewayId', ], 'routeFilterPrefixes' => [ 'shape' => 'RouteFilterPrefixList', ], 'bgpPeers' => [ 'shape' => 'BGPPeerList', ], ], ], 'VirtualInterfaceId' => [ 'type' => 'string', ], 'VirtualInterfaceList' => [ 'type' => 'list', 'member' => [ 'shape' => 'VirtualInterface', ], ], 'VirtualInterfaceName' => [ 'type' => 'string', ], 'VirtualInterfaceState' => [ 'type' => 'string', 'enum' => [ 'confirming', 'verifying', 'pending', 'available', 'down', 'deleting', 'deleted', 'rejected', ], ], 'VirtualInterfaceType' => [ 'type' => 'string', ], 'VirtualInterfaces' => [ 'type' => 'structure', 'members' => [ 'virtualInterfaces' => [ 'shape' => 'VirtualInterfaceList', ], ], ], ],];
